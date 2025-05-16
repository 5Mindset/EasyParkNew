<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleModels = VehicleModel::with(['vehicleBrand'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.models.index', compact('vehicleModels'));
    }

    public function create()
    {
        $vehicleBrands = VehicleBrand::with('vehicleType')->get();
        return view('admin.models.create', compact('vehicleBrands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
        ]);

        VehicleModel::create($request->only('name', 'vehicle_brand_id'));

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil ditambahkan.');
    }

    public function edit(VehicleModel $vehicleModel)
    {
        $vehicleBrands = VehicleBrand::with('vehicleType')->get();
        return view('admin.models.edit', compact('vehicleModel', 'vehicleBrands'));
    }

    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
        ]);

        $vehicleModel->update($request->only('name', 'vehicle_brand_id'));

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil diperbarui.');
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        $vehicleModel->delete();

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil dihapus.');
    }
}
