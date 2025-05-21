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
    /**
     * Menampilkan semua data rekaman parkir.
     */
    public function index(Request $request)
    {
        $query = ParkingRecord::with('vehicle.user');

        // Optional filtering
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        return response()->json($query->get());
    }

    /**
     * Menyimpan data rekaman parkir baru.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'entry_time' => ['required', 'date'],
            'exit_time' => ['nullable', 'date', 'after_or_equal:entry_time'],
            'status' => ['required', Rule::in(['parked', 'exited'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // ✅ CEK apakah kendaraan sudah punya record yang belum keluar (exit_time null)
        $existingRecord = ParkingRecord::where('vehicle_id', $request->vehicle_id)
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->first();

        if ($existingRecord) {
            return response()->json([
                'message' => 'Kendaraan ini masih dalam status parkir dan belum keluar.'
            ], 409); // 409 Conflict
        }

        $record = ParkingRecord::create($validator->validated());
        return response()->json($record->load('vehicle.user'), 201);
    }


    /**
     * Menampilkan detail rekaman parkir tertentu.
     */
    public function show($id)
    {
        $record = ParkingRecord::with('vehicle.user')->find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        return response()->json($record);
    }

    /**
     * Mengupdate data rekaman parkir.
     */
    public function update(Request $request, $id)
    {
        $record = ParkingRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'entry_time' => ['required', 'date'],
            'exit_time' => ['nullable', 'date', 'after_or_equal:entry_time'],
            'status' => ['required', Rule::in(['parked', 'exited'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $record->update($validator->validated());
        return response()->json($record->load('vehicle.user'));
    }

    /**
     * Menghapus data rekaman parkir.
     */
    public function destroy($id)
    {
        $record = ParkingRecord::find($id);

        if (!$record) {
            return response()->json(['message' => 'Parking record not found'], 404);
        }

        $record->delete();
        return response()->json(['message' => 'Parking record deleted'], 204);
    }

    /**
     * Mendapatkan semua kendaraan yang sedang parkir (belum keluar).
     */
    public function active()
    {
        $records = ParkingRecord::with(['vehicle.user'])
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

        return response()->json($record->load('vehicle.user'));
    }


    public function scan(Request $request)
    {
        $vehicleId = $request->input('vehicle_id');
        $vehicle = Vehicle::find($vehicleId);

        if (!$vehicle) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }

        $activeRecord = ParkingRecord::where('vehicle_id', $vehicleId)
            ->whereNull('exit_time')
            ->where('status', 'parked')
            ->first();

        if ($activeRecord) {
            // Proses sebagai EXIT
            $activeRecord->exit_time = now();
            $activeRecord->status = 'exited';
            $activeRecord->save();

            return response()->json([
                'message' => 'Kendaraan berhasil keluar parkir.',
                'record' => $activeRecord->load('vehicle.user'),
            ]);
        } else {
            // Proses sebagai ENTRY
            $newRecord = ParkingRecord::create([
                'vehicle_id' => $vehicleId,
                'entry_time' => now(),
                'status' => 'parked',
            ]);

            return response()->json([
                'message' => 'Kendaraan berhasil masuk parkir.',
                'record' => $newRecord->load('vehicle.user'),
            ]);
        }
    }
}
