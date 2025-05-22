<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $parkingAreaId = $request->input('parking_area_id');

        $vehicle = Vehicle::find($vehicleId);
        if (!$vehicle) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }

        $activeRecord = ParkingRecord::where('vehicle_id', $vehicleId)
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->first();

        if ($activeRecord) {
            $activeRecord->exit_time = now();
            $activeRecord->status = 'exited';
            $activeRecord->save();

            return response()->json([
                'message' => 'Kendaraan berhasil keluar parkir.',
                'record' => $activeRecord->load(['vehicle.user', 'parkingArea']),
            ]);
        } else {
            // Cek apakah area parkir diisi
            if (!$parkingAreaId) {
                return response()->json(['message' => 'Parking area is required for entry'], 422);
            }

            $newRecord = ParkingRecord::create([
                'vehicle_id' => $vehicleId,
                'parking_area_id' => $parkingAreaId,
                'entry_time' => now(),
                'status' => 'parked',
            ]);

            return response()->json([
                'message' => 'Kendaraan berhasil masuk parkir.',
                'record' => $newRecord->load(['vehicle.user', 'parkingArea']),
            ]);
        }
    }
}
