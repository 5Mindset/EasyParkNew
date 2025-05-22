<?php

namespace App\Http\Controllers;

use App\Models\ParkingRecord;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\ParkingArea;
use Illuminate\Http\Request;

class ParkingRecordController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input pencarian/filter
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'status' => ['nullable', 'in:parked,left'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'parking_area_id' => ['nullable', 'exists:parking_areas,id'], // ✅ validasi tambahan
        ]);

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $status = $request->status;
        $vehicleId = $request->vehicle_id;
        $vehicleTypeId = $request->vehicle_type_id;
        $parkingAreaId = $request->parking_area_id;

        $parkingRecords = ParkingRecord::with([
                'vehicle.model.vehicleBrand',
                'vehicle.model.vehicleType',
                'vehicle.user',
                'parkingArea' // ✅ relasi area parkir
            ])
            ->when($fromDate, fn($query) => $query->whereDate('entry_time', '>=', $fromDate))
            ->when($toDate, fn($query) => $query->whereDate('entry_time', '<=', $toDate))
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($vehicleId, fn($query) => $query->where('vehicle_id', $vehicleId))
            ->when($vehicleTypeId, function ($query) use ($vehicleTypeId) {
                $query->whereHas('vehicle.model.vehicleBrand.vehicleType', function ($q) use ($vehicleTypeId) {
                    $q->where('id', $vehicleTypeId);
                });
            })
            ->when($parkingAreaId, fn($query) => $query->where('parking_area_id', $parkingAreaId)) // ✅ filter area parkir
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = ['parked', 'left'];
        $vehicles = Vehicle::orderBy('plate_number')->get();
        $vehicleTypes = VehicleType::orderBy('name')->get();
        $parkingAreas = ParkingArea::orderBy('name')->get(); // ✅ ambil area parkir

        return view('admin.parking_records.index', compact(
            'parkingRecords',
            'statuses',
            'vehicles',
            'vehicleTypes',
            'parkingAreas' // ✅ lempar ke view
        ));
    }

    public function show(ParkingRecord $parkingRecord)
    {
        $parkingRecord->load([
            'vehicle.model.vehicleBrand',
            'vehicle.model.vehicleType',
            'vehicle.user',
            'parkingArea' // ✅ load area parkir
        ]);

        return view('admin.parking_records.show', compact('parkingRecord'));
    }

    public function create()
    {
        abort(403);
    }

    public function store(Request $request)
    {
        abort(403);
    }

    public function edit(ParkingRecord $parkingRecord)
    {
        abort(403);
    }

    public function update(Request $request, ParkingRecord $parkingRecord)
    {
        abort(403);
    }

    public function destroy(ParkingRecord $parkingRecord)
    {
        abort(403);
    }
}
