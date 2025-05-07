@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Judul Halaman --}}
    <div class="mb-2">
        <h3 class="fw-bold">Tambah Merek Kendaraan</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('vehicle-brands.index') }}" class="text-decoration-none text-muted">
                Merek Kendaraan
            </a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Tambah</span>
        </p>
    </div>

    {{-- Form Tambah --}}
    <div class="card border-0 shadow rounded-4 mt-3">
        <div class="card-body p-4">
            <form action="{{ route('vehicle-brands.store') }}" method="POST">
                @csrf

                {{-- Input Nama --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Merek</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="Contoh: Honda, Yamaha, Kawasaki"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
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
