<?php

namespace App\Http\Controllers;

use App\Models\VehicleModel;
use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleModels = VehicleModel::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')
          ->paginate(10); // paginate, bukan all()

        return view('admin.models.index', compact('vehicleModels'));
    }

    public function create()
    {
        $vehicleBrands = VehicleBrand::all();
        $vehicleTypes = VehicleType::all();
        
        return view('admin.models.create', compact('vehicleBrands', 'vehicleTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        VehicleModel::create($request->all());

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil ditambahkan.');
    }

    public function edit(VehicleModel $vehicleModel)
    {
        $vehicleBrands = VehicleBrand::all();
        $vehicleTypes = VehicleType::all();

        return view('admin.models.edit', compact('vehicleModel', 'vehicleBrands', 'vehicleTypes'));
    }

    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_brand_id' => 'required|exists:vehicle_brands,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $vehicleModel->update($request->all());

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil diperbarui.');
    }

    public function destroy(VehicleModel $vehicleModel)
    {
        $vehicleModel->delete();

        return redirect()->route('vehicle-models.index')->with('success', 'Model kendaraan berhasil dihapus.');
    }
}
