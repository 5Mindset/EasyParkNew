<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

class GuestVehicleController extends Controller
{
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

        $guestVehicle = GuestVehicle::create([
            'plate_number' => $request->plate_number,
            'name' => $request->name, // ✅ diperbaiki
            'vehicle_type_id' => $request->vehicle_type_id,
            'entry_time' => $request->entry_time ?? now(),
            'exit_time' => $request->exit_time,
            'status' => $request->status,
        ]);

        return response()->json($guestVehicle->load('vehicleType'), 201);
    }

    public function show($id)
    {
        $guestVehicle = GuestVehicle::with('vehicleType')->findOrFail($id);
        return response()->json($guestVehicle);
    }

    public function update(Request $request, $id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);

        $request->validate([
            'plate_number' => 'required|string|max:20|unique:guest_vehicles,plate_number,' . $guestVehicle->id,
            'name' => 'required|string|max:100', // ✅ ganti owner_name jadi name
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'entry_time' => 'nullable|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
        ]);

        $guestVehicle->update([
            'plate_number' => $request->plate_number,
            'name' => $request->name, // ✅ diperbaiki
            'vehicle_type_id' => $request->vehicle_type_id,
            'entry_time' => $request->entry_time,
            'exit_time' => $request->exit_time,
            'status' => $request->status,
        ]);

        return response()->json($guestVehicle->load('vehicleType'));
    }

    public function destroy($id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);
        $guestVehicle->delete();

        return response()->json(null, 204);
    }

    public function exitVehicle($id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);

        if ($guestVehicle->status === 'exited') {
            return response()->json([
                'message' => 'Kendaraan sudah keluar sebelumnya.'
            ], 400);
        }

        $guestVehicle->update([
            'status' => 'exited',
            'exit_time' => now(),
        ]);

        return response()->json([
            'message' => 'Status kendaraan berhasil diubah menjadi exited.',
            'data' => $guestVehicle->load('vehicleType'),
        ]);
    }
}
