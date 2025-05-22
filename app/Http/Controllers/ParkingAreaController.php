<?php

namespace App\Http\Controllers;

use App\Models\ParkingArea;
use Illuminate\Http\Request;

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

        ParkingArea::create([
            'name' => $request->name,
            'max_area' => (float) $request->max_area,
        ]);


        return redirect()->route('parking-areas.index')
            ->with('success', 'Area parkir berhasil ditambahkan.');
    }

    public function edit(ParkingArea $parkingArea)
    {
        return view('admin.parking_areas.edit', compact('parkingArea'));
    }

    public function update(Request $request, ParkingArea $parkingArea)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_area' => 'required|numeric|min:0',
        ]);

        $parkingArea->update([
            'name' => $request->name,
            'max_area' => (float) $request->max_area,
        ]);


        return redirect()->route('parking-areas.index')
            ->with('success', 'Area parkir berhasil diperbarui.');
    }

    public function destroy(ParkingArea $parkingArea)
    {
        $parkingArea->delete();

        return redirect()->route('parking-areas.index')
            ->with('success', 'Area parkir berhasil dihapus.');
    }
}
