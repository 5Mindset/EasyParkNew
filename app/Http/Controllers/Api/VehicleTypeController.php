<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return VehicleType::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_types,name',
        ]);

        $vehicleType = VehicleType::create($request->only('name'));
        return response()->json($vehicleType, 201);
    }

    public function show($id)
    {
        $vehicleType = VehicleType::findOrFail($id);
        return response()->json($vehicleType);
    }

    public function update(Request $request, $id)
    {
        $vehicleType = VehicleType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_types,name,' . $vehicleType->id,
        ]);

        $vehicleType->update($request->only('name'));
        return response()->json($vehicleType);
    }

    public function destroy($id)
    {
        $vehicleType = VehicleType::findOrFail($id);
        $vehicleType->delete();

        return response()->json(null, 204);
    }
}
