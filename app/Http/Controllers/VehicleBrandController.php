<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class VehicleBrandController extends Controller
{
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

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        return view('admin.brands.create', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_brands,name',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        try {
            VehicleBrand::create($validated);

            return redirect()->route('vehicle-brands.index')
                ->with('success', 'Merek kendaraan berhasil ditambahkan!');
        } catch (QueryException $e) {
            Log::error('VehicleBrand store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan merek kendaraan. Periksa input Anda.');
        }
    }

    public function edit($id)
    {
        $vehicleBrand = VehicleBrand::findOrFail($id);
        $vehicleTypes = VehicleType::all();

        return view('admin.brands.edit', compact('vehicleBrand', 'vehicleTypes'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
        ]);

        try {
            $vehicleBrand = VehicleBrand::findOrFail($id);
            $vehicleBrand->update($validated);

            return redirect()->route('vehicle-brands.index')
                ->with('success', 'Merek kendaraan berhasil diperbarui!');
        } catch (QueryException $e) {
            Log::error('VehicleBrand update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui merek kendaraan. Periksa input Anda.');
        }
    }

    public function destroy($id)
    {
        try {
            $vehicleBrand = VehicleBrand::findOrFail($id);
            $vehicleBrand->delete();

            return redirect()->route('vehicle-brands.index')
                ->with('success', 'Merek kendaraan berhasil dihapus!');
        } catch (QueryException $e) {
            Log::error('VehicleBrand delete failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Gagal menghapus merek kendaraan. Data mungkin sedang digunakan.');
        }
    }
}
