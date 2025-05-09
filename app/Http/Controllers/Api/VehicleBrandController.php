<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    public function index()
    {
        try {
            $brands = VehicleBrand::all();
            return response()->json($brands);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicle brands',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function getByType($typeId)
    {
        try {
            // Find distinct brands that have models with the given vehicle_type_id
            $brands = VehicleBrand::whereHas('models', function ($query) use ($typeId) {
                $query->where('vehicle_type_id', $typeId);
            })->get();

            if ($brands->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'No brands found for this vehicle type'
                ]);
            }

            return response()->json($brands);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message'=> 'Failed to fetch brands for vehicle type',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
