@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Judul Halaman --}}
        <div class="mb-2">
            <h3 class="fw-bold">Edit Merek Kendaraan</h3>
            <p class="text-muted small mb-0">
                <a href="{{ route('vehicle-brands.index') }}" class="text-decoration-none text-muted">
                    Merek Kendaraan
                </a>
                <span class="mx-1">/</span>
                <span class="text-primary fw-semibold">Edit</span>
            </p>
        </div>

        {{-- Notifikasi Error Global --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Edit --}}
        <div class="card border-0 shadow rounded-4 mt-3">
            <div class="card-body p-4">
                <form action="{{ route('vehicle-brands.update', $vehicleBrand->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Merek</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Contoh: Honda, Yamaha, Kawasaki" value="{{ old('name', $vehicleBrand->name) }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Jenis Kendaraan --}}
                    <div class="mb-3">
                        <label for="vehicle_type_id" class="form-label">Jenis Kendaraan</label>
                        <select name="vehicle_type_id" id="vehicle_type_id"
                            class="form-select @error('vehicle_type_id') is-invalid @enderror" required>
                            <option value="" disabled>-- Pilih Jenis Kendaraan --</option>
                            @foreach ($vehicleTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('vehicle_type_id', $vehicleBrand->vehicle_type_id) == $type->id ? 'selected' : '' }}>
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
