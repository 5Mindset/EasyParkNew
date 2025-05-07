@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Halaman --}}
    <div class="mb-2">
        <h3 class="fw-bold">Form Edit Model Kendaraan</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('vehicle-models.index') }}" class="text-decoration-none text-muted">
                Model Kendaraan
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Edit</span>
        </p>
    </div>

    {{-- Form Edit --}}
    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('vehicle-models.update', $vehicleModel->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Input Nama Model --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Model</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $vehicleModel->name) }}"
                        placeholder="Contoh: Vario, Supra"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Merek Kendaraan --}}
                <div class="mb-3">
                    <label for="vehicle_brand_id" class="form-label">Merek Kendaraan</label>
                    <select 
                        name="vehicle_brand_id" 
                        id="vehicle_brand_id" 
                        class="form-select @error('vehicle_brand_id') is-invalid @enderror" 
                        required
                    >
                        <option value="">Pilih Merek</option>
                        @foreach ($vehicleBrands as $brand)
                            <option value="{{ $brand->id }}" 
                                {{ old('vehicle_brand_id', $vehicleModel->vehicle_brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_brand_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Jenis Kendaraan --}}
                <div class="mb-3">
                    <label for="vehicle_type_id" class="form-label">Jenis Kendaraan</label>
                    <select 
                        name="vehicle_type_id" 
                        id="vehicle_type_id" 
                        class="form-select @error('vehicle_type_id') is-invalid @enderror" 
                        required
                    >
                        <option value="">Pilih Jenis</option>
                        @foreach ($vehicleTypes as $type)
                            <option value="{{ $type->id }}" 
                                {{ old('vehicle_type_id', $vehicleModel->vehicle_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Update --}}
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
