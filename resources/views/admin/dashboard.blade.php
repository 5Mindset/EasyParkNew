@extends('layouts.app')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Dashboard Cards -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Mahasiswa Card -->
                    <div class="col-xxl-3 col-md-6 mb-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Mahasiswa</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalMahasiswa ?? '0' }}</h6>
                                        <span class="text-muted small">Total Mahasiswa</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kendaraan Card -->
                    <div class="col-xxl-3 col-md-6 mb-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Kendaraan</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle bg-success text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalKendaraan ?? '0' }}</h6>
                                        <span class="text-muted small">Total Kendaraan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parkir Mahasiswa Card -->
                    <div class="col-xxl-3 col-md-6 mb-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-parking me-2"></i>Parkir Mahasiswa</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle bg-warning text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalParkirMahasiswa ?? '0' }}</h6>
                                        <span class="text-muted small">Transaksi Parkir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parkir Tamu Card -->
                    <div class="col-xxl-3 col-md-6 mb-4">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Parkir Tamu</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle bg-danger text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalParkirTamu ?? '0' }}</h6>
                                        <span class="text-muted small">Transaksi Tamu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Dashboard Cards -->
            <!-- Monitoring Parkir Hari Ini -->
            <div class="col-12 mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Monitoring Parkir Hari Ini</h5>
                    </div>
                    <div class="card-body px-4 py-3">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light text-muted text-uppercase small">
                                    <tr>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Plat Nomor</th>
                                        <th scope="col">Jenis Kendaraan</th>
                                        <th scope="col">Jam Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($parkirHariIni as $data)
                                        @php
                                            $isMotor = strtolower($data['tipe_kendaraan']) === 'motor';
                                            $icon = $isMotor ? 'bi-bicycle' : 'bi-car-front-fill'; // pakai bicycle untuk motor
                                            $badgeColor = $data['tipe'] === 'Mahasiswa' ? 'primary' : 'danger';
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="badge bg-{{ $badgeColor }}">
                                                    <i class="bi bi-person-fill me-1"></i> {{ $data['tipe'] }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $data['name'] }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-dark-subtle text-dark-emphasis px-3 py-2 rounded-pill">
                                                    {{ $data['plat'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <i
                                                    class="fa-solid {{ $icon }} me-1"></i>{{ ucfirst($data['tipe_kendaraan']) }}
                                            </td>
                                            <td class="text-success fw-medium">
                                                <i class="bi bi-arrow-right-circle-fill me-1"></i>
                                                {{ \Carbon\Carbon::parse($data['entry_time'])->format('H:i') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="bi bi-info-circle"></i> Belum ada kendaraan parkir hari ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- End Monitoring -->
        </div>
    </section>

</main>
