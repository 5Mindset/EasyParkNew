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

        </div>
    </section>

</main>
