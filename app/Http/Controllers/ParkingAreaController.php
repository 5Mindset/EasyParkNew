<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ParkingAreaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $parkingAreas = ParkingArea::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.parking_areas.index', compact('parkingAreas'));
    }

    public function create()
    {
        return view('admin.parking_areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_area' => 'required|numeric|min:0',
        ]);

        try {
            ParkingArea::create([
                'name' => $request->name,
                'max_area' => (float) $request->max_area,
            ]);

            return redirect()->route('parking-areas.index')
                ->with('success', 'Area parkir berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('ParkingArea store failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan area parkir. Periksa input Anda.');
        }
    }

    public function edit(ParkingArea $parkingArea)
    {
        $hasParkedVehicles = $parkingArea->parkingRecords()
            ->where('status', 'parked')
            ->exists();

        $hasParkedGuestVehicles = $parkingArea->guestVehicles()
            ->where('status', 'parked')
            ->exists();

        if ($hasParkedVehicles || $hasParkedGuestVehicles) {
            return redirect()->route('parking-areas.index')
                ->with('error', 'Area parkir tidak bisa diedit karena ada kendaraan (mahasiswa/tamu) yang sedang parkir.');
        }

        return view('admin.parking_areas.edit', [
            'parkingArea' => $parkingArea,
            'is_locked' => false,
        ]);
    }

    public function update(Request $request, ParkingArea $parkingArea)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_area' => 'required|numeric|min:0',
        ]);

        try {
            $parkingArea->update([
                'name' => $request->name,
                'max_area' => (float) $request->max_area,
            ]);

            return redirect()->route('parking-areas.index')
                ->with('success', 'Area parkir berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('ParkingArea update failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui area parkir. Periksa input Anda.');
        }
    }

    public function destroy(ParkingArea $parkingArea)
    {
        try {
            $parkingArea->delete();

            return redirect()->route('parking-areas.index')
                ->with('success', 'Area parkir berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('ParkingArea delete failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Gagal menghapus area parkir. Data mungkin sedang digunakan.');
        }
    }
}
