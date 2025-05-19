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
    const MAX_PARKING_AREA = 896.0;

    public function getCurrentUsedArea()
    {
        return Vehicle::with('model.vehicleType')->get()->sum(function ($vehicle) {
            return $vehicle->model->vehicleType->area_size ?? 0;
        });
    }

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

        $users = User::all();

        return view('admin.vehicles.create', compact('types', 'brands', 'models', 'users'));
    }

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
    //         'vehicle_model_id' => 'required|exists:vehicle_models,id',
    //         'user_id' => 'required|exists:users,id',
    //         'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     // Ambil total area parkir yang sudah digunakan
    //     $currentUsedArea = $this->getCurrentUsedArea();

    //     // Ambil model kendaraan beserta tipe-nya
    //     $model = VehicleModel::with('vehicleType')->find($request->vehicle_model_id);

    //     // Validasi jika model/tipenya tidak ditemukan
    //     if (!$model || !$model->vehicleType) {
    //         return redirect()->back()->withInput()->with('error', 'Tipe kendaraan tidak ditemukan.');
    //     }

    //     // Ukuran area kendaraan baru
    //     $newArea = $model->vehicleType->area_size;

    //     // Cek apakah masih cukup ruang parkir
    //     if (($currentUsedArea + $newArea) > self::MAX_PARKING_AREA) {
    //         return redirect()->back()->withInput()->with('error', 'Kapasitas parkir penuh. Tidak bisa menambahkan kendaraan baru.');
    //     }

    //     // Persiapkan data untuk disimpan
    //     $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);
    //     $data['plate_number'] = strtoupper($data['plate_number']);

    //     // Upload STNK jika ada
    //     if ($request->hasFile('stnk_image')) {
    //         $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
    //     }

    //     // Simpan kendaraan
    //     $vehicle = Vehicle::create($data);

    //     // Buat QR Code
    //     $qrPath = 'uploads/qrcodes/' . $vehicle->id . '_' . Str::random(6) . '.svg';
    //     $qrData = route('vehicles.show', $vehicle->id);
    //     $qrImage = QrCode::format('svg')->size(200)->generate($qrData);

    //     Storage::disk('public')->put($qrPath, $qrImage);

    //     // Simpan path QR Code ke database
    //     $vehicle->update(['qr_code' => $qrPath]);

    //     return redirect()->route('vehicles.index')->with('success', 'Data kendaraan berhasil ditambahkan.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number',
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data yang diperlukan saja
        $data = $request->only(['plate_number', 'vehicle_model_id', 'user_id']);
        $data['plate_number'] = strtoupper($data['plate_number']); // Ubah ke huruf kapital

        // Upload gambar STNK jika ada
        if ($request->hasFile('stnk_image')) {
            $data['stnk_image'] = $request->file('stnk_image')->store('uploads/stnk', 'public');
        }

        // Simpan kendaraan ke database
        $vehicle = Vehicle::create($data);

        // Buat QR Code dengan link ke halaman detail kendaraan
        $qrPath = 'uploads/qrcodes/' . $vehicle->id . '_' . Str::random(6) . '.svg';
        $qrData = route('vehicles.show', $vehicle->id);
        $qrImage = QrCode::format('svg')->size(200)->generate($qrData);

        // Simpan QR Code ke storage public
        Storage::disk('public')->put($qrPath, $qrImage);

        // Update path QR Code ke database
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

        $users = User::all();

        return view('admin.vehicles.edit', compact('vehicle', 'types', 'brands', 'models', 'users'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'vehicle_model_id' => 'required|exists:vehicle_models,id',
            'user_id' => 'required|exists:users,id',
            'stnk_image' => 'nullable|image|max:2048',
        ]);

        $stnkPath = $vehicle->stnk_image;

        if ($request->hasFile('stnk_image')) {
            if ($vehicle->stnk_image) {
                Storage::disk('public')->delete($vehicle->stnk_image);
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
