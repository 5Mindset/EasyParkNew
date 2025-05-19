@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Halaman --}}
    <div class="mb-2">
        <h3 class="fw-bold">Tambah Area Parkir</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('parking-areas.index') }}" class="text-decoration-none text-muted">
                Area Parkir
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Tambah</span>
        </p>
    </div>

    {{-- Form Tambah --}}
    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('parking-areas.store') }}" method="POST">
                @csrf

                {{-- Input Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Area</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Contoh: Area Utama, Area Selatan"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Max Area --}}
                <div class="mb-3">
                    <label for="max_area" class="form-label">Maksimum Area (m²)</label>
                    <input 
                        type="number" 
                        step="0.01"
                        min="0"
                        name="max_area" 
                        id="max_area" 
                        class="form-control @error('max_area') is-invalid @enderror" 
                        placeholder="Contoh: 896.00"
                        value="{{ old('max_area') }}"
                        required
                    >
                    @error('max_area')
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
