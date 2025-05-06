<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index()
    {
        // Menyertakan relasi brand dan type
        return VehicleModel::with(['vehicleBrand', 'vehicleType'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_models,name',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $vehicleModel = VehicleModel::create($request->only(['name', 'vehicle_brand_id', 'vehicle_type_id']));
        return response()->json($vehicleModel->load(['vehicleBrand', 'vehicleType']), 201);
    }

    public function show($id)
    {
        $vehicleModel = VehicleModel::with(['vehicleBrand', 'vehicleType'])->findOrFail($id);
        return response()->json($vehicleModel);
    }

    public function update(Request $request, $id)
    {
        $vehicleModel = VehicleModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:vehicle_models,name,' . $vehicleModel->id,
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $vehicleModel->update($request->only(['name', 'vehicle_brand_id', 'vehicle_type_id']));
        return response()->json($vehicleModel->load(['vehicleBrand', 'vehicleType']));
    }

    public function destroy($id)
    {
        $vehicleModel = VehicleModel::findOrFail($id);
        $vehicleModel->delete();

        return response()->json(null, 204);
    }
}
