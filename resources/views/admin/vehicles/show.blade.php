@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        <div class="mb-4">
            <h2 class="fw-bold">Detail Kendaraan</h2>
            <nav class="small text-muted">
                <a href="{{ route('vehicles.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-chevron-left"></i> Kendaraan
                </a>
                <span class="mx-1">/</span>
                <span class="text-primary">Detail</span>
            </nav>
        </div>

        {{-- Kartu Utama --}}
        <div class="card border-0 rounded-4">
            <div class="row g-0">
                <div class="col-12">
                    <div class="card-body p-4">
                        {{-- Plat Nomor --}}
                        <div class="mb-4">
                            <h3 class="fw-bold text-primary">Plat Nomor Kendaraan</h3>
                            <h1 class="fw-bold text-dark" style="font-size: 48px;">
                                {{ $vehicle->plate_number }}
                            </h1>
                        </div>

                        {{-- Info Kendaraan --}}
                        <div class="row mb-4">
                            @foreach ([
            'Model' => $vehicle->model->name,
            'Merek' => $vehicle->model->vehicleBrand->name ?? '-',
            'Jenis' => $vehicle->model->vehicleType->name ?? '-',
            'Pemilik' => $vehicle->user->name ?? '-',
        ] as $label => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="text-muted mb-2">{{ $label }}</h6>
                                        <p class="fw-medium mb-0">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Gambar STNK dan QR Code --}}
                        <div class="mt-4">
                            <div class="row g-4">
                                {{-- Gambar STNK --}}
                                @if ($vehicle->stnk_image)
                                    <div class="col-md-8">
                                        <p class="fw-semibold mb-2 text-muted">Gambar STNK</p>
                                        <div class="ratio ratio-16x9 rounded overflow-hidden">
                                            <img src="{{ asset('storage/' . $vehicle->stnk_image) }}" class="img-fluid"
                                                alt="STNK" style="object-fit: cover;">
                                        </div>
                                    </div>
                                @endif
                                {{-- QR Code --}}
                                <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                    <h6 class="text-muted mb-3">QR Code</h6>
                                    @if ($vehicle->qr_code && file_exists(storage_path('app/public/' . $vehicle->qr_code)))
                                        <div class="ratio ratio-1x1" style="max-width: 220px;">
                                            <img src="{{ asset('storage/' . $vehicle->qr_code) }}" class="img-fluid"
                                                alt="QR Code">
                                        </div>
                                    @else
                                        <div class="text-muted small">QR Code tidak tersedia</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
