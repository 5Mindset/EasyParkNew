@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul Halaman --}}
        <div class="mb-4">
            <h2 class="fw-bold">Detail Kendaraan Tamu</h2>
            <nav class="small text-muted">
                <a href="{{ route('guest-vehicles.index') }}" class="text-decoration-none text-muted">
                    <i class="bi bi-chevron-left"></i> Kendaraan Tamu
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
                                {{ $guestVehicle->plate_number }}
                            </h1>
                        </div>

                        {{-- Info Kendaraan --}}
                        <div class="row mb-4">
                            @foreach ([
                                'Nama' => $guestVehicle->name,
                                'Jenis Kendaraan' => $guestVehicle->vehicleType->name ?? '-',
                                'Status' => ucfirst($guestVehicle->status),
                                'Waktu Masuk' => $guestVehicle->entry_time,
                                'Waktu Keluar' => $guestVehicle->exit_time ?? '-',
                            ] as $label => $value)
                                <div class="col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded">
                                        <h6 class="text-muted mb-2">{{ $label }}</h6>
                                        <p class="fw-medium mb-0">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Catatan: Kalau ada gambar STNK atau QR code untuk tamu, bisa ditambah di sini --}}
                        {{-- Contoh jika ada atribut stnk_image atau qr_code di model GuestVehicle --}}
                        @if ($guestVehicle->stnk_image || $guestVehicle->qr_code)
                            <div class="mt-4">
                                <div class="row g-4">
                                    @if ($guestVehicle->stnk_image)
                                        <div class="col-md-8">
                                            <p class="fw-semibold mb-2 text-muted">Gambar STNK</p>
                                            <div class="ratio ratio-16x9 rounded overflow-hidden">
                                                <img src="{{ asset('storage/' . $guestVehicle->stnk_image) }}" class="img-fluid"
                                                    alt="STNK" style="object-fit: cover;">
                                            </div>
                                        </div>
                                    @endif
                                    @if ($guestVehicle->qr_code && file_exists(storage_path('app/public/' . $guestVehicle->qr_code)))
                                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                            <h6 class="text-muted mb-3">QR Code</h6>
                                            <div class="ratio ratio-1x1" style="max-width: 220px;">
                                                <img src="{{ asset('storage/' . $guestVehicle->qr_code) }}" class="img-fluid"
                                                    alt="QR Code">
                                            </div>
                                        </div>
                                    @elseif($guestVehicle->qr_code)
                                        <div class="col-md-4 d-flex flex-column align-items-center justify-content-center">
                                            <h6 class="text-muted mb-3">QR Code</h6>
                                            <div class="text-muted small">QR Code tidak tersedia</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
