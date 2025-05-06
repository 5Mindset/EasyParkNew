<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    public function index()
    {
        return VehicleBrand::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_brands,name',
        ]);

        $vehicleBrand = VehicleBrand::create($request->only('name'));
        return response()->json($vehicleBrand, 201);
    }

    public function show($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);
        return response()->json($vehicleBrand);
    }

    public function update(Request $request, $id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_brands,name,' . $vehicleBrand->id,
        ]);

        $vehicleBrand->update($request->only('name'));
        return response()->json($vehicleBrand);
    }

    public function destroy($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleBrand->delete();

        return response()->json(null, 204);
    }
}
