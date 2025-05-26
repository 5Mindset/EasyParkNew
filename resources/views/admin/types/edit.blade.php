@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Judul Halaman --}}
        <div class="mb-2">
            <h3 class="fw-bold">Form Edit Tipe Kendaraan</h3>
            <p class="text-muted small mb-0">
                <a href="{{ route('vehicle-types.index') }}" class="text-decoration-none text-muted">
                    Tipe Kendaraan
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
                <form action="{{ route('vehicle-types.update', $vehicleType->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Input Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Jenis</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $vehicleType->name) }}" placeholder="Contoh: Motor, Mobil" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Ukuran Area --}}
                    <div class="mb-3">
                        <label for="area_size" class="form-label">Ukuran Area (m²)</label>
                        <input type="number" step="0.01" min="0" name="area_size" id="area_size"
                            class="form-control @error('area_size') is-invalid @enderror"
                            value="{{ old('area_size', $vehicleType->area_size) }}" placeholder="Contoh: 2.5" required>
                        @error('area_size')
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
