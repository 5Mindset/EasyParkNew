<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_size' => 'nullable|numeric|min:0',
        ]);

        try {
            VehicleType::create($validated);

            return redirect()->route('vehicle-types.index')
                ->with('success', 'Jenis kendaraan berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('VehicleType store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan jenis kendaraan. Periksa input Anda.');
        }
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('admin.types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'area_size' => 'nullable|numeric|min:0',
        ]);

        try {
            $vehicleType->update($validated);

            return redirect()->route('vehicle-types.index')
                ->with('success', 'Jenis kendaraan berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('VehicleType update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui jenis kendaraan. Periksa input Anda.');
        }
    }

    public function destroy(VehicleType $vehicleType)
    {
        try {
            $vehicleType->delete();

            return redirect()->route('vehicle-types.index')
                ->with('success', 'Jenis kendaraan berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('VehicleType delete failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Gagal menghapus jenis kendaraan. Data mungkin sedang digunakan.');
        }
    }
}
