@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        <div class="mb-4">
            <h2 class="fw-bold">Detail Parkir Mahasiswa</h2>
            <nav class="small text-muted">
                <a href="{{ route('parking-records.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-chevron-left"></i> Riwayat Parkir
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
                            <h3 class="fw-bold text-primary">Plat Nomor</h3>
                            <h1 class="fw-bold text-dark" style="font-size: 48px;">
                                {{ $parkingRecord->vehicle->plate_number ?? '-' }}
                            </h1>
                        </div>

                        {{-- Info Parkir --}}
                        <div class="row mb-4">
                            @foreach ([
                                'Nama Mahasiswa' => $parkingRecord->vehicle->user->name ?? '-',
                                'Merek Kendaraan' => $parkingRecord->vehicle->model->vehicleBrand->name ?? '-',
                                'Model Kendaraan' => $parkingRecord->vehicle->model->name ?? '-',
                                'Jenis Kendaraan' => $parkingRecord->vehicle->model->vehicleType->name ?? '-',
                                'Status Parkir' => ucfirst($parkingRecord->status),
                                'Waktu Masuk' => $parkingRecord->entry_time,
                                'Waktu Keluar' => $parkingRecord->exit_time ?? '-',
                            ] as $label => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="text-muted mb-2">{{ $label }}</h6>
                                        <p class="fw-medium mb-0">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- QR Code --}}
                        @if ($parkingRecord->qr_code && file_exists(storage_path('app/public/' . $parkingRecord->qr_code)))
                            <div class="mt-4">
                                <div class="text-center">
                                    <h6 class="text-muted mb-3">QR Code Parkir</h6>
                                    <div class="ratio ratio-1x1" style="max-width: 220px; margin: auto;">
                                        <img src="{{ asset('storage/' . $parkingRecord->qr_code) }}" class="img-fluid"
                                            alt="QR Code Parkir">
                                    </div>
                                </div>
                            </div>
                        @elseif($parkingRecord->qr_code)
                            <div class="mt-4 text-center text-muted small">
                                <i class="bi bi-info-circle"></i> QR Code tidak tersedia
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
