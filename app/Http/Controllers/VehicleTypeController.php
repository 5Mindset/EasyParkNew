<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicleTypes = VehicleType::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.types.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('admin.types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        VehicleType::create($request->all());

        return redirect()->route('vehicle-types.index')
            ->with('success', 'Jenis kendaraan berhasil ditambahkan.');
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('admin.types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $vehicleType->update($request->all());

        return redirect()->route('vehicle-types.index')
            ->with('success', 'Jenis kendaraan berhasil diperbarui.');
    }

    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        return redirect()->route('vehicle-types.index')
            ->with('success', 'Jenis kendaraan berhasil dihapus.');
    }
}
