<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParkingRecord;
use Illuminate\Http\Request;

class ParkingRecordController extends Controller
{
    public function index()
    {
        return ParkingRecord::with('vehicle')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'entry_time' => 'required|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
        ]);

        $record = ParkingRecord::create($request->all());
        return response()->json($record->load('vehicle'), 201);
    }

    public function show($id)
    {
        $record = ParkingRecord::with('vehicle')->findOrFail($id);
        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = ParkingRecord::findOrFail($id);

        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'entry_time' => 'required|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
        ]);

        $record->update($request->all());
        return response()->json($record->load('vehicle'));
    }

    public function destroy($id)
    {
        $record = ParkingRecord::findOrFail($id);
        $record->delete();

        return response()->json(null, 204);
    }
     public function active()
{
    $records = ParkingRecord::with(['vehicle', 'vehicle.user'])
        ->whereNull('exit_time') // hanya kendaraan yang belum keluar
        ->get()
        ->map(function ($record) {
            return [
                'id' => $record->id,
                'vehicle_id' => $record->vehicle_id,
                'plate_number' => $record->vehicle->plate_number ?? null,
                'owner_name' => $record->vehicle->user->name ?? null,
                'entry_time' => $record->entry_time,
                'status' => $record->status,
            ];
        });

    return response()->json($records);
}

}
