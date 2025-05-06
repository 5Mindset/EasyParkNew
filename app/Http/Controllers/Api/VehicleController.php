<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        return Vehicle::with(['model', 'user'])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'qr_code' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id', 'qr_code']);

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk_images', 'public');
        }

        $vehicle = Vehicle::create($data);
        return response()->json($vehicle->load(['model', 'user']), 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::with(['model', 'user'])->findOrFail($id);
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'qr_code' => 'nullable|string|max:255',
        ]);

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id', 'qr_code']);

        if ($request->hasFile('stnk_image')) {
            // Hapus gambar lama jika ada
            if ($vehicle->stnk_image) {
                Storage::disk('public')->delete($vehicle->stnk_image);
            }
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk_images', 'public');
        }

        $vehicle->update($data);
        return response()->json($vehicle->load(['model', 'user']));
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle->stnk_image) {
            Storage::disk('public')->delete($vehicle->stnk_image);
        }
        $vehicle->delete();

        return response()->json(null, 204);
    }
}
