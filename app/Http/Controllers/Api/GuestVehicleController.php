<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

use App\Models\VehicleType;
use App\Models\ParkingArea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GuestVehicleController extends Controller
{
    // List semua kendaraan tamu yang sedang parkir
    public function index()
    {
        return GuestVehicle::with('vehicleType', 'parkingArea')
            ->where('status', 'parked')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:guest_vehicles,plate_number',
            'name' => 'required|string|max:100',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'entry_time' => 'nullable|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
            'parking_area_id' => 'nullable|exists:parking_areas,id',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $vehicleType = VehicleType::findOrFail($request->vehicle_type_id);
                $requiredArea = (float) $vehicleType->area_size;

                // Pakai default parking_area_id 1 jika tidak dikirim
                $parkingAreaId = $request->parking_area_id ?? 1;
                $parkingArea = ParkingArea::where('id', $parkingAreaId)->lockForUpdate()->firstOrFail();
                $availableArea = (float) $parkingArea->max_area;

                if ($availableArea < $requiredArea) {
                    return response()->json([
                        'message' => 'Kapasitas parkir tidak mencukupi. Area tersedia: ' . $availableArea . ', dibutuhkan: ' . $requiredArea
                    ], 409);
                }

                // Kurangi kapasitas parkir
                $parkingArea->max_area = $availableArea - $requiredArea;
                $parkingArea->save();

                // Simpan data tamu
                $guestVehicle = GuestVehicle::create([
                    'plate_number' => $request->plate_number,
                    'name' => $request->name,
                    'vehicle_type_id' => $request->vehicle_type_id,
                    'entry_time' => $request->entry_time ?? now(),
                    'exit_time' => $request->exit_time,
                    'status' => $request->status,
                    'parking_area_id' => $parkingAreaId,
                ]);

                return response()->json($guestVehicle->load('vehicleType', 'parkingArea'), 201);
            });
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kendaraan tamu', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data kendaraan tamu.'], 500);
        }
    }

    // Detail kendaraan tamu berdasarkan ID
    public function show($id)
    {
        $guestVehicle = GuestVehicle::with('vehicleType', 'parkingArea')->findOrFail($id);
        return response()->json($guestVehicle);
    }

    // Update data kendaraan tamu
    public function update(Request $request, $id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);

        $request->validate([
            'plate_number' => 'required|string|max:20|unique:guest_vehicles,plate_number,' . $guestVehicle->id,
            'name' => 'required|string|max:100',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'entry_time' => 'nullable|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
            'parking_area_id' => 'nullable|exists:parking_areas,id',
        ]);

        $oldVehicleType = $guestVehicle->vehicleType;
        $oldParkingAreaId = $guestVehicle->parking_area_id;
        $newParkingAreaId = $request->parking_area_id ?? $oldParkingAreaId;

        try {
            return DB::transaction(function () use ($guestVehicle, $request, $oldVehicleType, $oldParkingAreaId, $newParkingAreaId) {
                $newVehicleType = VehicleType::findOrFail($request->vehicle_type_id);

                // Jika pindah area parkir atau tipe kendaraan berubah, harus update kapasitas area
                if ($oldParkingAreaId != $newParkingAreaId || $oldVehicleType->id != $newVehicleType->id) {
                    // Kembalikan area di area lama jika status masih 'parked'
                    if ($guestVehicle->status === 'parked') {
                        $oldArea = ParkingArea::where('id', $oldParkingAreaId)->lockForUpdate()->firstOrFail();
                        $oldArea->max_area += (float) $oldVehicleType->area_size;
                        $oldArea->save();

                        $newArea = ParkingArea::where('id', $newParkingAreaId)->lockForUpdate()->firstOrFail();
                        $requiredArea = (float) $newVehicleType->area_size;

                        if ($newArea->max_area < $requiredArea) {
                            throw new \Exception('Kapasitas parkir di area baru tidak mencukupi.');
                        }

                        $newArea->max_area -= $requiredArea;
                        $newArea->save();
                    }
                }

                $guestVehicle->update([
                    'plate_number' => $request->plate_number,
                    'name' => $request->name,
                    'vehicle_type_id' => $request->vehicle_type_id,
                    'entry_time' => $request->entry_time,
                    'exit_time' => $request->exit_time,
                    'status' => $request->status,
                    'parking_area_id' => $newParkingAreaId,
                ]);

                return response()->json($guestVehicle->load('vehicleType', 'parkingArea'));
            });
        } catch (\Exception $e) {
            Log::error('Gagal update kendaraan tamu', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage() ?: 'Terjadi kesalahan saat mengupdate data kendaraan tamu.'], 500);
        }
    }

    // Hapus kendaraan tamu
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $guestVehicle = GuestVehicle::with('vehicleType')->findOrFail($id);

                if ($guestVehicle->status === 'parked') {
                    $vehicleType = $guestVehicle->vehicleType;
                    $requiredArea = (float) $vehicleType->area_size;

                    $parkingArea = ParkingArea::where('id', $guestVehicle->parking_area_id)->lockForUpdate()->firstOrFail();

                    $parkingArea->max_area += $requiredArea;
                    $parkingArea->save();
                }

                $guestVehicle->delete();

                return response()->json(null, 204);
            });
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kendaraan tamu', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data kendaraan tamu.'], 500);
        }
    }

    // Tandai kendaraan keluar
    public function exitVehicle($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $guestVehicle = GuestVehicle::with('vehicleType')->findOrFail($id);

                if ($guestVehicle->status === 'exited') {
                    return response()->json([
                        'message' => 'Kendaraan sudah keluar sebelumnya.'
                    ], 400);
                }

                $vehicleType = $guestVehicle->vehicleType;
                $requiredArea = (float) $vehicleType->area_size;

                $parkingArea = ParkingArea::where('id', $guestVehicle->parking_area_id)->lockForUpdate()->firstOrFail();

                $parkingArea->max_area += $requiredArea;
                $parkingArea->save();

                $guestVehicle->update([
                    'status' => 'exited',
                    'exit_time' => now(),
                ]);

                return response()->json([
                    'message' => 'Kendaraan berhasil keluar, area parkir dikembalikan, dan log otomatis tercatat.',
                    'data' => $guestVehicle->fresh()->load('vehicleType', 'parkingArea'),
                    'returned_area' => $requiredArea,
                    'current_available_area' => $parkingArea->fresh()->max_area,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Gagal mengeluarkan kendaraan tamu', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan saat mengeluarkan kendaraan tamu.'], 500);
        }
    }
}
