<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    // Menampilkan daftar merek kendaraan dengan pencarian dan pagination
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleBrands = VehicleBrand::with('vehicleType')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.brands.index', compact('vehicleBrands'));
    }

    // Menampilkan form untuk menambah merek kendaraan
    public function create()
    {
        $vehicleTypes = VehicleType::all();
        return view('admin.brands.create', compact('vehicleTypes'));
    }

    // Menyimpan data merek kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        VehicleBrand::create($request->only('name', 'vehicle_type_id'));

        return redirect()->route('vehicle-brands.index')->with('success', 'Merek kendaraan berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit merek kendaraan
    public function edit($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleTypes = VehicleType::all();

        return view('admin.brands.edit', compact('vehicleBrand', 'vehicleTypes'));
    }

    // Memperbarui data merek kendaraan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleBrand->update($request->only('name', 'vehicle_type_id'));

        return redirect()->route('vehicle-brands.index')->with('success', 'Merek kendaraan berhasil diperbarui!');
    }

    // Menghapus merek kendaraan
    public function destroy($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleBrand->delete();

        return redirect()->route('vehicle-brands.index')->with('success', 'Merek kendaraan berhasil dihapus!');
    }
}
