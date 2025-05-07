@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Halaman --}}
    <div class="mb-2">
        <h3 class="fw-bold">Form Edit Kendaraan</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('vehicles.index') }}" class="text-decoration-none text-muted">
                Kendaraan
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Edit</span>
        </p>
    </div>

    {{-- Form Edit --}}
    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Input Nomor Plat Kendaraan --}}
                <div class="mb-3">
                    <label for="plate_number" class="form-label">Nomor Plat Kendaraan</label>
                    <input 
                        type="text" 
                        name="plate_number" 
                        id="plate_number" 
                        class="form-control @error('plate_number') is-invalid @enderror" 
                        value="{{ old('plate_number', $vehicle->plate_number) }}" 
                        required
                    >
                    @error('plate_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Model Kendaraan --}}
                <div class="mb-3">
                    <label for="vehicle_model_id" class="form-label">Model Kendaraan</label>
                    <select 
                        name="vehicle_model_id" 
                        id="vehicle_model_id" 
                        class="form-select @error('vehicle_model_id') is-invalid @enderror" 
                        required
                    >
                        <option value="">Pilih Model</option>
                        @foreach ($models as $model)
                            <option value="{{ $model->id }}" 
                                {{ old('vehicle_model_id', $vehicle->vehicle_model_id) == $model->id ? 'selected' : '' }}>
                                {{ $model->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_model_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Pengguna --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">Pengguna</label>
                    <select 
                        name="user_id" 
                        id="user_id" 
                        class="form-select @error('user_id') is-invalid @enderror" 
                        required
                    >
                        <option value="">Pilih Pengguna</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" 
                                {{ old('user_id', $vehicle->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Gambar STNK --}}
                <div class="mb-3">
                    <label for="stnk_image" class="form-label">Upload Gambar STNK</label>
                    <input 
                        type="file" 
                        name="stnk_image" 
                        id="stnk_image" 
                        class="form-control @error('stnk_image') is-invalid @enderror"
                        accept="image/*"
                    >
                    @error('stnk_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if ($vehicle->stnk_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $vehicle->stnk_image) }}" alt="STNK Image" class="img-fluid" style="max-width: 200px;">
                        </div>
                    @endif
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
