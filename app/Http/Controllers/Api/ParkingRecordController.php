<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\VehicleType;
use App\Models\ParkingArea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class ParkingRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = ParkingRecord::with(['vehicle.user', 'parkingArea']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->has('parking_area_id')) {
            $query->where('parking_area_id', $request->parking_area_id);
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'parking_area_id' => ['required', 'exists:parking_areas,id'],
            'entry_time' => ['required', 'date'],
            'exit_time' => ['nullable', 'date', 'after_or_equal:entry_time'],
            'status' => ['required', Rule::in(['parked', 'exited'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $existingRecord = ParkingRecord::where('vehicle_id', $request->vehicle_id)
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->first();

        if ($existingRecord) {
            return response()->json([
                'message' => 'Kendaraan ini masih dalam status parkir dan belum keluar.'
            ], 409);
        }

        $record = ParkingRecord::create($validator->validated());
        return response()->json($record->load(['vehicle.user', 'parkingArea']), 201);
    }

    public function show($id)
    {
        $record = ParkingRecord::with(['vehicle.user', 'parkingArea'])->find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = ParkingRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'parking_area_id' => ['required', 'exists:parking_areas,id'],
            'entry_time' => ['required', 'date'],
            'exit_time' => ['nullable', 'date', 'after_or_equal:entry_time'],
            'status' => ['required', Rule::in(['parked', 'exited'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record->update($validator->validated());
        return response()->json($record->load(['vehicle.user', 'parkingArea']));
    }

    public function destroy($id)
    {
        $record = ParkingRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        $record->delete();
        return response()->json(['message' => 'Parking record deleted'], 204);
    }

    public function active()
    {
        $records = ParkingRecord::with(['vehicle.user', 'parkingArea'])
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'vehicle_id' => $record->vehicle_id,
                    'plate_number' => optional($record->vehicle)->plate_number,
                    'owner_name' => optional($record->vehicle->user)->name,
                    'entry_time' => $record->entry_time,
                    'status' => $record->status,
                    'parking_area' => optional($record->parkingArea)->name,
                ];
            });

        return response()->json($records);
    }

    public function exit($id)
    {
        $record = ParkingRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        if ($record->exit_time !== null) {
            return response()->json(['message' => 'Vehicle already exited'], 400);
        }

        $record->exit_time = now();
        $record->status = 'exited';
        $record->save();

        return response()->json($record->load(['vehicle.user', 'parkingArea']));
    }

    public function scan(Request $request)
    {
        $vehicleId = $request->input('vehicle_id');
        $parkingAreaId = $request->input('parking_area_id', 1); // default ke 1

        $vehicle = Vehicle::with('model.vehicleBrand.vehicleType')->find($vehicleId);
        if (!$vehicle) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }

        $vehicleType = $vehicle->model->vehicleBrand->vehicleType ?? null;
        if (!$vehicleType) {
            return response()->json(['message' => 'Tipe kendaraan tidak ditemukan'], 422);
        }

        $activeRecord = ParkingRecord::where('vehicle_id', $vehicleId)
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->first();

        $parkingArea = ParkingArea::find($parkingAreaId);
        if (!$parkingArea) {
            return response()->json(['message' => 'Area parkir tidak ditemukan'], 404);
        }

        if ($activeRecord) {
            // Kendaraan keluar
            return $this->handleVehicleExit($parkingArea, $vehicleType, $activeRecord);
        } else {
            // Kendaraan masuk
            return $this->handleVehicleEntry($vehicleType, $vehicleId, $parkingAreaId);
        }
    }

    private function handleVehicleExit($parkingArea, $vehicleType, $activeRecord)
    {
        try {
            DB::transaction(function () use ($parkingArea, $vehicleType, $activeRecord) {
                Log::info('Vehicle exit - adding area back', [
                    'current_max_area' => $parkingArea->max_area,
                    'vehicle_area_size' => $vehicleType->area_size,
                ]);

                $parkingArea->max_area = (float) $parkingArea->max_area + (float) $vehicleType->area_size;
                $parkingArea->save();

                $activeRecord->exit_time = now();
                $activeRecord->status = 'exited';
                $activeRecord->save();

                Log::info('Vehicle exit completed', [
                    'new_max_area' => $parkingArea->max_area,
                    'record_id' => $activeRecord->id,
                ]);
            });

            return response()->json([
                'message' => 'Kendaraan berhasil keluar parkir.',
                'record' => $activeRecord->load(['vehicle.user', 'parkingArea']),
            ]);
        } catch (\Exception $e) {
            Log::error('Vehicle exit failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Gagal mengeluarkan kendaraan'], 500);
        }
    }

    private function handleVehicleEntry($vehicleType, $vehicleId, $parkingAreaId)
    {
        // Cek kapasitas terlebih dahulu SEBELUM transaction
        $parkingArea = ParkingArea::find($parkingAreaId);
        $maxArea = (float) $parkingArea->max_area;
        $vehicleArea = (float) $vehicleType->area_size;

        Log::info('Vehicle entry attempt', [
            'current_max_area' => $maxArea,
            'required_area' => $vehicleArea,
            'vehicle_id' => $vehicleId
        ]);

        // Pengecekan awal - jika tidak cukup, langsung tolak
        if ($maxArea < $vehicleArea) {
            Log::warning('Insufficient parking capacity', [
                'available_area' => $maxArea,
                'required_area' => $vehicleArea
            ]);

            return response()->json([
                'message' => 'Kapasitas parkir tidak mencukupi. Area tersedia: ' . $maxArea . ', dibutuhkan: ' . $vehicleArea
            ], 409);
        }

        try {
            return DB::transaction(function () use ($vehicleType, $vehicleId, $parkingAreaId) {
                // Lock parking area untuk mencegah race condition
                $lockedParkingArea = ParkingArea::where('id', $parkingAreaId)->lockForUpdate()->first();

                $currentMaxArea = (float) $lockedParkingArea->max_area;
                $requiredArea = (float) $vehicleType->area_size;

                // Double check di dalam transaction dengan data yang di-lock
                if ($currentMaxArea < $requiredArea) {
                    Log::warning('Insufficient parking capacity (double check)', [
                        'available_area' => $currentMaxArea,
                        'required_area' => $requiredArea
                    ]);

                    throw new \Exception('Kapasitas parkir tidak mencukupi. Area tersedia: ' . $currentMaxArea . ', dibutuhkan: ' . $requiredArea);
                }

                // Update kapasitas parkir
                $lockedParkingArea->max_area = $currentMaxArea - $requiredArea;
                $lockedParkingArea->save();

                // Buat record parkir
                $newRecord = ParkingRecord::create([
                    'vehicle_id' => $vehicleId,
                    'parking_area_id' => $parkingAreaId,
                    'entry_time' => now(),
                    'status' => 'parked',
                ]);

                Log::info('Vehicle entry successful', [
                    'previous_max_area' => $currentMaxArea,
                    'new_max_area' => $lockedParkingArea->max_area,
                    'used_area' => $requiredArea,
                    'record_id' => $newRecord->id
                ]);

                return response()->json([
                    'message' => 'Kendaraan berhasil masuk parkir.',
                    'record' => $newRecord->load(['vehicle.user', 'parkingArea']),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Vehicle entry failed', [
                'error' => $e->getMessage(),
                'vehicle_id' => $vehicleId
            ]);

            return response()->json(['message' => $e->getMessage()], 409);
        }
    }
    public function history(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $records = ParkingRecord::with([
            'vehicle.model.vehicleBrand.vehicleType',  // Eager loading sampai vehicleType
            'vehicle.user'
        ])
            ->whereHas('vehicle', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('entry_time')
            ->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        $result = $records->map(function ($record) {
            return [
                'plate_number' => optional($record->vehicle)->plate_number,
                'owner_name' => optional($record->vehicle->user)->name,
                'vehicle_type_name' => optional($record->vehicle->model->vehicleBrand->vehicleType)->name,
                'entry_time' => $record->entry_time,
                'exit_time' => $record->exit_time,
                'status' => $record->exit_time === null ? 'Masuk' : 'Keluar',
            ];
        });

        return response()->json($result);
    }

    public function lastStatus(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        $lastRecord = ParkingRecord::whereHas('vehicle', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->orderByDesc('entry_time')
            ->first();

        if (!$lastRecord) {
            return response()->json(['message' => 'Tidak ada data parkir ditemukan'], 404);
        }

        return response()->json([
            'status' => $lastRecord->exit_time === null ? 'parked' : 'exited',
        ]);
    }
    public function lastEntryExit(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Terakhir kali masuk (record terbaru berdasarkan entry_time)
        $lastEntry = ParkingRecord::with('vehicle.user')
            ->whereHas('vehicle', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderByDesc('entry_time')
            ->first();

        // Terakhir kali keluar (record dengan exit_time, diurutkan berdasarkan exit_time)
        $lastExit = ParkingRecord::with('vehicle.user')
            ->whereHas('vehicle', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereNotNull('exit_time')
            ->orderByDesc('exit_time')
            ->first();

        return response()->json([
            'last_entry' => $lastEntry ? [
                'plate_number' => optional($lastEntry->vehicle)->plate_number,
                'owner_name' => optional($lastEntry->vehicle->user)->name,
                'entry_time' => $lastEntry->entry_time,
                'status' => 'Masuk',
            ] : null,

            'last_exit' => $lastExit ? [
                'plate_number' => optional($lastExit->vehicle)->plate_number,
                'owner_name' => optional($lastExit->vehicle->user)->name,
                'exit_time' => $lastExit->exit_time,
                'status' => 'Keluar',
            ] : null,
        ]);
    }
}
