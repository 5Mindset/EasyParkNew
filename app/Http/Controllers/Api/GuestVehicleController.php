<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

use App\Models\ParkingRecord;
use App\Models\Vehicle;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\VehicleType;
use App\Models\ParkingArea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class GuestVehicleController extends Controller
{
    // List semua kendaraan tamu yang sedang parkir
    public function index()
    {
        return GuestVehicle::with('vehicleType')
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
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $vehicleType = VehicleType::findOrFail($request->vehicle_type_id);
                $requiredArea = (float) $vehicleType->area_size;

                // Ambil dan kunci area parkir default (misalnya ID 1)
                $parkingArea = ParkingArea::where('id', 1)->lockForUpdate()->firstOrFail();
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
                ]);

                return response()->json($guestVehicle->load('vehicleType'), 201);
            });
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kendaraan tamu', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data kendaraan tamu.'], 500);
        }
    }

    // Detail kendaraan tamu berdasarkan ID
    public function show($id)
    {
        $guestVehicle = GuestVehicle::with('vehicleType')->findOrFail($id);
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
        ]);

        $guestVehicle->update([
            'plate_number' => $request->plate_number,
            'name' => $request->name,
            'vehicle_type_id' => $request->vehicle_type_id,
            'entry_time' => $request->entry_time,
            'exit_time' => $request->exit_time,
            'status' => $request->status,
        ]);

        return response()->json($guestVehicle->load('vehicleType'));
    }

    // Hapus kendaraan tamu
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $guestVehicle = GuestVehicle::with('vehicleType')->findOrFail($id);

                // Jika kendaraan masih berstatus 'parked', kembalikan area parkir
                if ($guestVehicle->status === 'parked') {
                    $vehicleType = $guestVehicle->vehicleType;
                    $requiredArea = (float) $vehicleType->area_size;

                    // Ambil dan kunci area parkir default (misalnya ID 1)
                    $parkingArea = ParkingArea::where('id', 1)->lockForUpdate()->firstOrFail();

                    // Kembalikan area parkir
                    $parkingArea->max_area = $parkingArea->max_area + $requiredArea;
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

    // Tandai kendaraan keluar (update status dan exit_time)
    // Trigger di DB akan otomatis buat log di guest_vehicle_logs
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

                // Ambil data vehicle type untuk mengetahui area yang perlu dikembalikan
                $vehicleType = $guestVehicle->vehicleType;
                $requiredArea = (float) $vehicleType->area_size;

                // Ambil dan kunci area parkir default (misalnya ID 1)
                $parkingArea = ParkingArea::where('id', 1)->lockForUpdate()->firstOrFail();

                // Kembalikan area parkir
                $parkingArea->max_area = $parkingArea->max_area + $requiredArea;
                $parkingArea->save();

                // Update status kendaraan
                $guestVehicle->update([
                    'status' => 'exited',
                    'exit_time' => now(),
                ]);

                return response()->json([
                    'message' => 'Kendaraan berhasil keluar, area parkir dikembalikan, dan log otomatis tercatat.',
                    'data' => $guestVehicle->fresh()->load('vehicleType'),
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
