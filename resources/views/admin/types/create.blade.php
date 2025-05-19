@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Halaman --}}
    <div class="mb-2">
        <h3 class="fw-bold">Tambah Jenis Kendaraan</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('vehicle-types.index') }}" class="text-decoration-none text-muted">
                Jenis Kendaraan
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Tambah</span>
        </p>
    </div>

    {{-- Form Tambah --}}
    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('vehicle-types.store') }}" method="POST">
                @csrf

                {{-- Input Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Jenis</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Contoh: Motor, Mobil"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Area Size --}}
                <div class="mb-3">
                    <label for="area_size" class="form-label">Ukuran Area (m²)</label>
                    <input 
                        type="number" 
                        step="0.01"
                        min="0"
                        name="area_size" 
                        id="area_size" 
                        class="form-control @error('area_size') is-invalid @enderror" 
                        placeholder="Contoh: 2.5"
                        value="{{ old('area_size') }}"
                    >
                    @error('area_size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
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
