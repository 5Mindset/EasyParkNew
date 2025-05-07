<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleStudentController extends Controller
{
    public function index()
    {
        $userId = auth()->id(); // mahasiswa hanya lihat kendaraannya sendiri
        return Vehicle::with('model')
            ->where('user_id', $userId)
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['plate_number', 'vehicle_model_id']);
        $data['user_id'] = auth()->id(); // otomatis ambil user id mahasiswa

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk_images', 'public');
        }

        $vehicle = Vehicle::create($data);
        return response()->json($vehicle->load('model'), 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::with('model')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
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
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        if ($vehicle->stnk_image) {
            Storage::disk('public')->delete($vehicle->stnk_image);
        }
        $vehicle->delete();

        return response()->json(null, 204);
    }
}
