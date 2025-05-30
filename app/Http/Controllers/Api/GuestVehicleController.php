<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

class GuestVehicleController extends Controller
{
    // List semua kendaraan tamu yang sedang parkir
    public function index()
    {
        return GuestVehicle::with('vehicleType')
            ->where('status', 'parked')
            ->get();
    }

    // Simpan data kendaraan tamu baru
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
            'name' => $request->name,
            'vehicle_type_id' => $request->vehicle_type_id,
            'entry_time' => $request->entry_time ?? now(),
            'exit_time' => $request->exit_time,
            'status' => $request->status,
        ]);

        return response()->json($guestVehicle->load('vehicleType'), 201);
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
        $guestVehicle = GuestVehicle::findOrFail($id);
        $guestVehicle->delete();

        return response()->json(null, 204);
    }

    // Tandai kendaraan keluar (update status dan exit_time)
    // Trigger di DB akan otomatis buat log di guest_vehicle_logs
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
            'message' => 'Kendaraan berhasil keluar dan log otomatis tercatat.',
            'data' => $guestVehicle->fresh()->load('vehicleType'),
        ]);
    }
}
