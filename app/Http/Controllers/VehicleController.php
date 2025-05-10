<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

    public function create(Request $request)
    {
        $types = VehicleType::orderBy('name')->get();
        $users = User::where('role', 'Mahasiswa')->orderBy('name')->get(); // Mahasiswa

        $brands = collect();
        $models = collect();

        if ($request->vehicle_type_id) {
            $brands = VehicleBrand::whereHas('vehicleModels', function ($q) use ($request) {
                $q->where('vehicle_type_id', $request->vehicle_type_id);
            })->orderBy('name')->get();
        }

        if ($request->vehicle_brand_id) {
            $models = VehicleModel::where('vehicle_brand_id', $request->vehicle_brand_id)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->orderBy('name')
                ->get();
        }

        return view('admin.vehicles.create', compact('types', 'users', 'brands', 'models'));
    }

    public function getBrandsByType($typeId)
    {
        // Ambil merek kendaraan berdasarkan tipe
        $brands = VehicleBrand::whereHas('vehicleModels', function ($query) use ($typeId) {
            $query->where('vehicle_type_id', $typeId);
        })->get();

        return response()->json($brands);
    }

    public function getModelsByBrand($brandId)
    {
        // Ambil model kendaraan berdasarkan merek
        $models = VehicleModel::where('vehicle_brand_id', $brandId)->get();

        return response()->json($models);
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

        // Generate QR code
        $qrPath = 'uploads/qrcodes/' . $vehicle->id . '_' . Str::random(6) . '.svg';
        $qrData = route('vehicles.show', $vehicle->id);
        $qrImage = QrCode::format('svg')->size(200)->generate($qrData);

        Storage::disk('public')->put($qrPath, $qrImage);
        $vehicle->update(['qr_code' => $qrPath]);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('model', 'user');

        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        // Memuat data kendaraan dengan relasi
        $vehicle->load('model');

        // Ambil semua tipe kendaraan
        $types = VehicleType::orderBy('name')->get();

        // Ambil merek kendaraan sesuai tipe kendaraan yang sudah dipilih
        $brands = VehicleBrand::whereHas('vehicleModels', function ($query) use ($vehicle) {
            $query->where('vehicle_type_id', $vehicle->model->vehicle_type_id);
        })->orderBy('name')->get();

        // Ambil model kendaraan sesuai merek dan tipe kendaraan yang sudah dipilih
        $models = VehicleModel::where('vehicle_brand_id', $vehicle->model->vehicle_brand_id)
            ->where('vehicle_type_id', $vehicle->model->vehicle_type_id)
            ->orderBy('name')->get();

        // Ambil pengguna dengan role Mahasiswa
        $users = User::where('role', 'Mahasiswa')->orderBy('name')->get();

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

        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);

        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy(Vehicle $vehicle)
    {
        // Hapus gambar jika ada
        if ($vehicle->stnk_image && Storage::disk('public')->exists($vehicle->stnk_image)) {
            Storage::disk('public')->delete($vehicle->stnk_image);
        }

        if ($vehicle->qr_code && Storage::disk('public')->exists($vehicle->qr_code)) {
            Storage::disk('public')->delete($vehicle->qr_code);
        }

        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil dihapus.');
    }
}
