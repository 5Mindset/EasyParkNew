<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuestVehicle;
use Illuminate\Http\Request;

class GuestVehicleController extends Controller
{
    public function index()
    {
        return GuestVehicle::with('vehicleModel')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:guest_vehicles,plate_number',
            'owner_name' => 'required|string|max:100',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'entry_time' => 'nullable|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
        ]);

        $guestVehicle = GuestVehicle::create($request->all());

        return response()->json($guestVehicle->load('vehicleModel'), 201);
    }

    public function show($id)
    {
        $guestVehicle = GuestVehicle::with('vehicleModel')->findOrFail($id);
        return response()->json($guestVehicle);
    }

    public function update(Request $request, $id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);

        $request->validate([
            'plate_number' => 'required|string|max:20|unique:guest_vehicles,plate_number,' . $guestVehicle->id,
            'owner_name' => 'required|string|max:100',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'entry_time' => 'nullable|date',
            'exit_time' => 'nullable|date|after_or_equal:entry_time',
            'status' => 'required|in:parked,exited',
        ]);

        $guestVehicle->update($request->all());

        return response()->json($guestVehicle->load('vehicleModel'));
    }

    public function destroy($id)
    {
        $guestVehicle = GuestVehicle::findOrFail($id);
        $guestVehicle->delete();

        return response()->json(null, 204);
    }
}
