<?php

namespace App\Http\Controllers;

use App\Models\GuestVehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class GuestVehicleController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $status = $request->status;
        $vehicleTypeId = $request->vehicle_type_id;

        $guestVehicles = GuestVehicle::with('vehicleType')
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->whereDate('entry_time', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->whereDate('entry_time', '<=', $toDate);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($vehicleTypeId, function ($query) use ($vehicleTypeId) {
                $query->where('vehicle_type_id', $vehicleTypeId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $statuses = ['parked', 'left'];
        $vehicleTypes = VehicleType::orderBy('name')->get();

        return view('admin.guest_vehicles.index', compact('guestVehicles', 'statuses', 'vehicleTypes'));
    }

    public function show(GuestVehicle $guestVehicle)
    {
        $guestVehicle->load('vehicleType');
        return view('admin.guest_vehicles.show', compact('guestVehicle'));
    }

    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function edit(GuestVehicle $guestVehicle) { abort(403); }
    public function update(Request $request, GuestVehicle $guestVehicle) { abort(403); }
    public function destroy(GuestVehicle $guestVehicle) { abort(403); }
}
