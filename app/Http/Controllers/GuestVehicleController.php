<?php



namespace App\Http\Controllers;



use App\Models\GuestVehicle;

use App\Models\VehicleType;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;



class GuestVehicleController extends Controller

{

    public function index(Request $request)

    {

        $request->validate([

            'from_date' => ['nullable', 'date'],

            'to_date' => ['nullable', 'date'],

            'status' => ['nullable', 'in:parked,exited'],

            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],

        ]);



        $fromDate = $request->from_date;

        $toDate = $request->to_date;

        $status = $request->status;

        $vehicleTypeId = $request->vehicle_type_id;



        $guestVehicles = GuestVehicle::with('vehicleType')

            ->when($fromDate, fn($query) => $query->whereDate('entry_time', '>=', $fromDate))

            ->when($toDate, fn($query) => $query->whereDate('entry_time', '<=', $toDate))

            ->when($status, fn($query) => $query->where('status', $status))

            ->when($vehicleTypeId, fn($query) => $query->where('vehicle_type_id', $vehicleTypeId))

            ->latest()

            ->paginate(10)

            ->withQueryString();



        $statuses = ['parked', 'exited'];

        $vehicleTypes = VehicleType::orderBy('name')->get();



        return view('admin.guest_vehicles.index', compact('guestVehicles', 'statuses', 'vehicleTypes'));

    }



    public function exportPdf(Request $request)

    {

        $request->validate([

            'from_date' => ['nullable', 'date'],

            'to_date' => ['nullable', 'date'],

            'status' => ['nullable', 'in:parked,exited'],

            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],

        ]);



        $fromDate = $request->from_date;

        $toDate = $request->to_date;  // <== ini harus ada



        $status = $request->status;

        $vehicleTypeId = $request->vehicle_type_id;



        $guestVehicles = GuestVehicle::with('vehicleType')

            ->when($fromDate, fn($query) => $query->whereDate('entry_time', '>=', $fromDate))

            ->when($toDate, fn($query) => $query->whereDate('entry_time', '<=', $toDate))  // <== ini pakai $toDate yang sudah didefinisikan

            ->when($status, fn($query) => $query->where('status', $status))

            ->when($vehicleTypeId, fn($query) => $query->where('vehicle_type_id', $vehicleTypeId))

            ->latest()

            ->get();



        $pdf = Pdf::loadView('admin.guest_vehicles.pdf', compact('guestVehicles'));

        return $pdf->stream('riwayat-guest-vehicles.pdf');

    }



    public function show(GuestVehicle $guestVehicle)

    {

        $guestVehicle->load('vehicleType');

        return view('admin.guest_vehicles.show', compact('guestVehicle'));

    }



    public function create()

    {

        abort(403);

    }

    public function store(Request $request)

    {

        abort(403);

    }

    public function edit(GuestVehicle $guestVehicle)

    {

        abort(403);

    }

    public function update(Request $request, GuestVehicle $guestVehicle)

    {

        abort(403);

    }

    public function destroy(GuestVehicle $guestVehicle)

    {

        abort(403);

    }

}

