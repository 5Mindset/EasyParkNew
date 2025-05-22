<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $vehicles = Vehicle::with(['model.vehicleBrand.vehicleType', 'user'])
            ->when($search, function ($query, $search) {
                return $query->where('plate_number', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create(Request $request)
    {
        $types = VehicleType::all();

        $brands = $request->vehicle_type_id
            ? VehicleBrand::where('vehicle_type_id', $request->vehicle_type_id)->get()
            : collect();

        $models = $request->vehicle_brand_id
            ? VehicleModel::where('vehicle_brand_id', $request->vehicle_brand_id)->get()
            : collect();

        // Ambil hanya user dengan role mahasiswa
        $users = User::where('role', 'mahasiswa')->get();

        return view('admin.vehicles.create', compact('types', 'brands', 'models', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Validasi tambahan: hanya mahasiswa
        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'mahasiswa') {
            return back()->withErrors(['user_id' => 'Pengguna yang dipilih harus mahasiswa.'])->withInput();
        }

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);
        $data['plate_number'] = strtoupper($data['plate_number']);

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        $vehicle = Vehicle::create($data);

        $qrPath = 'uploads/qrcodes/' . $vehicle->id . '_' . Str::random(6) . '.svg';
        $qrData = route('vehicles.show', $vehicle->id);
        $qrImage = QrCode::format('svg')->size(200)->generate($qrData);

        Storage::disk('public')->put($qrPath, $qrImage);
        $vehicle->update(['qr_code' => $qrPath]);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['model.vehicleBrand.vehicleType', 'user']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $types = VehicleType::all();

        $selectedBrand = $vehicle->model->vehicleBrand ?? null;
        $selectedType = $selectedBrand->vehicleType ?? null;

        $brands = $selectedType
            ? VehicleBrand::where('vehicle_type_id', $selectedType->id)->get()
            : collect();

        $models = $selectedBrand
            ? VehicleModel::where('vehicle_brand_id', $selectedBrand->id)->get()
            : collect();

        // Hanya user mahasiswa
        $users = User::where('role', 'mahasiswa')->get();

        return view('admin.vehicles.edit', compact('vehicle', 'types', 'brands', 'models', 'users'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'mahasiswa') {
            return back()->withErrors(['user_id' => 'Pengguna yang dipilih harus mahasiswa.'])->withInput();
        }

        $stnkPath = $vehicle->stnk_image;

        if ($request->hasFile('stnk_image')) {
            if ($stnkPath) {
                Storage::disk('public')->delete($stnkPath);
            }
            $stnkPath = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        $vehicle->update([
            'plate_number' => strtoupper($request->plate_number),
            'vehicle_model_id' => $request->vehicle_model_id,
            'user_id' => $request->user_id,
            'stnk_image' => $stnkPath,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->stnk_image) {
            Storage::disk('public')->delete($vehicle->stnk_image);
        }

        if ($vehicle->qr_code) {
            Storage::disk('public')->delete($vehicle->qr_code);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
