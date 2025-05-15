<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleModelController extends Controller
{
    public function index()
    {
        return VehicleModel::with(['vehicle_brand', 'vehicle_type'])->get();
    }

    public function store(Request $request)
    {
        try {
            if ($request->user()->role !== 'admin' && $request->user()->role !== 'mahasiswa') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $request->validate([
                'name' => 'required|string|max:100|unique:vehicle_models,name',
                'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
            ]);

            $vehicleModel = VehicleModel::create($request->only(['name', 'vehicle_brand_id', 'vehicle_type_id']));
            $vehicleModel->loadMissing(['vehicle_brand', 'vehicle_type']);

            return response()->json([
                'success' => true,
                'message' => 'Model berhasil ditambahkan',
                'data' => $vehicleModel
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error creating vehicle model: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating vehicle model: ' . $e->getMessage() . ' | Stack: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create vehicle model',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $vehicleModel = VehicleModel::with(['vehicle_brand', 'vehicle_type'])->findOrFail($id);
        return response()->json($vehicleModel);
    }

    public function update(Request $request, $id)
    {
        try {
            $vehicleModel = VehicleModel::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:100|unique:vehicle_models,name,' . $vehicleModel->id,
                'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
            ]);

            $vehicleModel->update($request->only(['name', 'vehicle_brand_id', 'vehicle_type_id']));
            $vehicleModel->load(['vehicle_brand', 'vehicle_type']);

            return response()->json([
                'success' => true,
                'message' => 'Model berhasil diperbarui',
                'data' => $vehicleModel
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error updating vehicle model: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating vehicle model: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update vehicle model',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicleModel = VehicleModel::findOrFail($id);
            $vehicleModel->delete();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting vehicle model: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete vehicle model',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getByBrand($brandId)
    {
        try {
            $models = VehicleModel::where('vehicle_brand_id', $brandId)
                ->with(['vehicle_brand', 'vehicle_type'])
                ->get();

            return response()->json($models, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicle models by brand', [
                'brand_id' => $brandId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicle models by brand',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
