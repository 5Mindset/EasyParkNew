<?php

namespace App\Http\Controllers;

use App\Models\ParkingRecord;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\ParkingArea;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ParkingRecordController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'status' => ['nullable', 'in:parked,exited'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'parking_area_id' => ['nullable', 'exists:parking_areas,id'],
        ]);

        $parkingRecords = ParkingRecord::with([
            'vehicle.model.vehicleBrand',
            'vehicle.model.vehicleType',
            'vehicle.user',
            'parkingArea'
        ])
            ->when($request->from_date, fn($q) => $q->whereDate('entry_time', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('entry_time', '<=', $request->to_date))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))
            ->when($request->vehicle_type_id, function ($q) use ($request) {
                $q->whereHas('vehicle.model.vehicleType', function ($subQ) use ($request) {
                    $subQ->where('vehicle_types.id', $request->vehicle_type_id); // ? fix ambiguity
                });
            })
            ->when($request->parking_area_id, fn($q) => $q->where('parking_area_id', $request->parking_area_id))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.parking_records.index', [
            'parkingRecords' => $parkingRecords,
            'statuses' => ['parked', 'exited'],
            'vehicles' => Vehicle::orderBy('plate_number')->get(),
            'vehicleTypes' => VehicleType::orderBy('name')->get(),
            'parkingAreas' => ParkingArea::orderBy('name')->get(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'status' => ['nullable', 'in:parked,exited'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'parking_area_id' => ['nullable', 'exists:parking_areas,id'],
        ]);

        $parkingRecords = ParkingRecord::with([
            'vehicle.model.vehicleBrand',
            'vehicle.model.vehicleType',
            'vehicle.user',
            'parkingArea'
        ])
            ->when($request->from_date, fn($q) => $q->whereDate('entry_time', '>=', $request->from_date))
            ->when($request->to_date, fn($q) => $q->whereDate('entry_time', '<=', $request->to_date))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->vehicle_id, fn($q) => $q->where('vehicle_id', $request->vehicle_id))
            ->when($request->vehicle_type_id, function ($q) use ($request) {
                $q->whereHas('vehicle.model.vehicleType', function ($subQ) use ($request) {
                    $subQ->where('vehicle_types.id', $request->vehicle_type_id); // ? fix ambiguity
                });
            })
            ->when($request->parking_area_id, fn($q) => $q->where('parking_area_id', $request->parking_area_id))
            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.parking_records.pdf', compact('parkingRecords'));
        return $pdf->stream('riwayat-parkir.pdf');
    }

    public function show(ParkingRecord $parkingRecord)
    {
        $parkingRecord->load([
            'vehicle.model.vehicleBrand',
            'vehicle.model.vehicleType',
            'vehicle.user',
            'parkingArea'
        ]);

        return view('admin.parking_records.show', compact('parkingRecord'));
    }

    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(ParkingRecord $parkingRecord) { abort(403); }
    public function update(Request $request, ParkingRecord $parkingRecord) { abort(403); }
    public function destroy(ParkingRecord $parkingRecord) { abort(403); }
}
