@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Tombol Kembali --}}
    <div class="mb-2">
        <h3 class="fw-bold">Detail Mahasiswa</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('students.index') }}" class="text-decoration-none text-muted">Mahasiswa</a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Show</span>
        </p>
    </div>

    {{-- Card Detail Mahasiswa --}}
    <div class="card border-0 shadow rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">

                {{-- Foto Mahasiswa --}}
                <div class="col-md-3 text-center">
                    <div style="width: 150px; height: 150px; margin: 0 auto;">
                        @if ($student->image)
                            <img src="{{ asset('storage/' . $student->image) }}" alt="Foto Mahasiswa"
                                class="rounded-circle w-100 h-100 object-fit-cover">
                        @else
                            <div
                                class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">
                                <i class="bi bi-person-fill fs-1"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Detail Informasi --}}
                <div class="col-md-9">
                    <h4 class="fw-bold mb-3">{{ $student->full_name }}</h4>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>NIM:</strong><br>
                            {{ $student->nim ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong><br>
                            {{ $student->email }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>No. HP:</strong><br>
                            {{ $student->phone_number ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Tanggal Lahir:</strong><br>
                            {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->translatedFormat('d M Y') : '-' }}
                        </div>
                        <div class="col-md-12 mb-2">
                            <strong>Alamat:</strong><br>
                            {{ $student->address ?? '-' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Daftar Kendaraan --}}
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-primary text-white fw-semibold">
            Daftar Kendaraan Mahasiswa
        </div>
        <div class="card-body p-4">
            @if ($student->vehicles->isEmpty())
                <p class="text-muted">Mahasiswa ini belum memiliki data kendaraan.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No.</th>
                                <th>Plat Nomor</th>
                                <th>Model Kendaraan</th>
                                <th>Merek</th>
                                <th>Jenis Kendaraan</th>
                                <th>Foto STNK</th>
                                <th>Kode QR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->vehicles as $index => $vehicle)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $vehicle->plate_number }}</td>
                                    <td>{{ $vehicle->model->name ?? '-' }}</td>
                                    <td>{{ $vehicle->model?->vehicleBrand->name ?? '-' }}</td>
                                    <td>{{ $vehicle->model?->vehicleBrand?->vehicleType->name ?? '-' }}</td>
                                    <td>
                                        @if ($vehicle->stnk_image)
                                            <img src="{{ asset('storage/' . $vehicle->stnk_image) }}" alt="STNK Image"
                                                style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($vehicle->qr_code)
                                            <img src="{{ asset('storage/' . $vehicle->qr_code) }}" alt="QR Code"
                                                style="width: 50px; height: 50px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
