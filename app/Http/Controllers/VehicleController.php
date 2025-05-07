<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Models\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicles = Vehicle::with(['model', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('plate_number', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $models = VehicleModel::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.vehicles.create', compact('models', 'users'));
    }

    public function show(Vehicle $vehicle)
    {
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        $vehicle = Vehicle::create($data);

        // Generate QR code (format SVG, bukan PNG)
        $qrPath = 'uploads/qrcodes/' . $vehicle->id . '_' . Str::random(6) . '.svg';
        $qrData = route('vehicles.show', $vehicle->id);
        $qrImage = QrCode::format('svg')->size(200)->generate($qrData);

        Storage::disk('public')->put($qrPath, $qrImage);

        $vehicle->update(['qr_code' => $qrPath]);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function edit(Vehicle $vehicle)
    {
        $models = VehicleModel::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.vehicles.edit', compact('vehicle', 'models', 'users'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
