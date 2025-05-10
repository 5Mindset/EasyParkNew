<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class VehicleBrandController extends Controller
{
    // Menampilkan daftar merek kendaraan
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleBrands = VehicleBrand::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')
            ->paginate(10); // paginate, bukan all()

        return view('admin.brands.index', compact('vehicleBrands'));
    }

    // Menampilkan form untuk menambah merek kendaraan
    public function create()
    {
        return view('admin.brands.create');
    }

    // Menyimpan data merek kendaraan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        VehicleBrand::create($request->only('name'));

        return redirect()->route('vehicle-brands.index')->with('success', 'Merek kendaraan berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit merek kendaraan
    public function edit($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);

        return view('admin.brands.edit', compact('vehicleBrand'));
    }

    // Memperbarui data merek kendaraan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleBrand->update($request->only('name'));

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
