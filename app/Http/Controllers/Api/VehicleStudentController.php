<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class VehicleStudentController extends Controller
{
    public function index()
    {
        try {
            $userId = auth()->id();
            $vehicles = Vehicle::with('model.vehicle_brand', 'model.vehicle_type')
                ->where('user_id', $userId)
                ->get();
            return response()->json($vehicles);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicles: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
                'vehicle_model_id' => 'required|exists:vehicle_models,id',
                'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $request->only(['plate_number', 'vehicle_model_id']);
            $data['user_id'] = auth()->id();

            if ($request->hasFile('stnk_image')) {
                $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk_images', 'public');
            }

            $vehicle = Vehicle::create($data);
            return response()->json($vehicle->load('model'), 201);
        } catch (\Exception $e) {
            Log::error('Error creating vehicle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $vehicle = Vehicle::with('model.vehicle_brand', 'model.vehicle_type')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            return response()->json($vehicle);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

            $request->validate([
                'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
                'vehicle_model_id' => 'required|exists:vehicle_models,id',
                'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $request->only(['plate_number', 'vehicle_model_id']);

            if ($request->hasFile('stnk_image')) {
                if ($vehicle->stnk_image) {
                    Storage::disk('public')->delete($vehicle->stnk_image);
                }
                $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk_images', 'public');
            }

            $vehicle->update($data);
            return response()->json($vehicle->load('model'));
        } catch (\Exception $e) {
            Log::error('Error updating vehicle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
            if ($vehicle->stnk_image) {
                Storage::disk('public')->delete($vehicle->stnk_image);
            }
            $vehicle->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            Log::error('Error deleting vehicle: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete vehicle',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
