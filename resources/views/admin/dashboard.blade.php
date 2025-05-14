@extends('layouts.app')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Salam -->
    <div class="alert alert-info">
        Selamat datang, {{ auth()->user()->name }}! Semoga harimu menyenangkan 😊
    </div>

    <section class="section dashboard">
        <div class="row">

            <!-- Dashboard Cards -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Mahasiswa Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Mahasiswa</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalMahasiswa ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Total Mahasiswa</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kendaraan Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Kendaraan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalKendaraan ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Total Kendaraan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parkir Mahasiswa Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Parkir Mahasiswa</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                                        <i class="bi bi-parking"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalParkirMahasiswa ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Transaksi Parkir</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parkir Tamu Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Parkir Tamu</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                        <i class="bi bi-car-front-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalParkirTamu ?? '0' }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Transaksi Tamu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Dashboard Cards -->

            <!-- Grafik -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Parkir Mahasiswa Bulanan</h5>
                        <canvas id="parkirChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daftar Kendaraan Terakhir -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">5 Kendaraan Terakhir</h5>
                        <ul class="list-group">
                            @forelse($recentVehicles as $vehicle)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $vehicle->plate_number }}
                                    <span class="badge bg-primary">{{ $vehicle->created_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">Belum ada data kendaraan.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Status Sistem -->
            <div class="col-12 mt-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Status Sistem</h5>
                        <p>Sistem berjalan normal. Tidak ada kendala tercatat.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('parkirChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Transaksi Parkir Mahasiswa',
                data: {!! json_encode($chartData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });
</script>
@endpush
