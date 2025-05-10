@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-2">
        <h3 class="fw-bold">Tambah Kendaraan</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('vehicles.index') }}" class="text-decoration-none text-muted">
                Kendaraan
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Tambah</span>
        </p>
    </div>

    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            {{-- Form Filter Tipe > Merek > Model --}}
            <form action="{{ route('vehicles.create') }}" method="GET" class="row mb-4">
                <div class="col-md-4">
                    <label for="vehicle_type_id" class="form-label">Tipe Kendaraan</label>
                    <select name="vehicle_type_id" id="vehicle_type_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Pilih Tipe</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" {{ request('vehicle_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="vehicle_brand_id" class="form-label">Merek Kendaraan</label>
                    <select name="vehicle_brand_id" id="vehicle_brand_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Pilih Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('vehicle_brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="vehicle_model_id" class="form-label">Model Kendaraan</label>
                    <select name="vehicle_model_id" id="vehicle_model_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Pilih Model</option>
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}" {{ request('vehicle_model_id') == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- Form Simpan Data Kendaraan --}}
            <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Hidden input untuk menyimpan pilihan --}}
                <input type="hidden" name="vehicle_type_id" value="{{ request('vehicle_type_id') }}">
                <input type="hidden" name="vehicle_brand_id" value="{{ request('vehicle_brand_id') }}">
                <input type="hidden" name="vehicle_model_id" value="{{ request('vehicle_model_id') }}">

                <div class="mb-3">
                    <label for="plate_number" class="form-label">Nomor Plat Kendaraan</label>
                    <input type="text" name="plate_number" id="plate_number"
                        class="form-control @error('plate_number') is-invalid @enderror"
                        value="{{ old('plate_number') }}" required>
                    @error('plate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">Pengguna</label>
                    <select name="user_id" id="user_id"
                        class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="stnk_image" class="form-label">Upload Gambar STNK</label>
                    <input type="file" name="stnk_image" id="stnk_image"
                        class="form-control @error('stnk_image') is-invalid @enderror" accept="image/*">
                    @error('stnk_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
