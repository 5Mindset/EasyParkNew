@extends('layouts.app')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>


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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
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

                <!-- Monitoring Parkir Hari Ini -->
                <div class="col-12 mt-4">
                    <div class="card bg-white shadow rounded">
                        <div class="card-header bg-blue-600 text-white p-4 rounded-t">
                            <h5 class="mb-0 text-lg font-semibold">Monitoring Parkir Hari Ini</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto border-collapse border border-gray-300">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Tipe</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Plat Nomor</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Tipe Kendaraan</th>
                                            <th class="border border-gray-300 px-4 py-2 text-left">Jam Masuk</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($parkirHariIni as $data)
                                            <tr
                                                class="{{ $data['tipe'] === 'Mahasiswa' ? 'bg-blue-100 text-blue-900' : 'bg-red-100 text-red-900' }}">
                                                <td class="border border-gray-300 px-4 py-2 text-left font-medium">
                                                    {{ $data['tipe'] }}
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">{{ $data['name'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    <span
                                                        class="inline-block bg-gray-400 text-white text-xs px-2 py-1 rounded">
                                                        {{ $data['plat'] }}
                                                    </span>
                                                </td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    {{ $data['tipe_kendaraan'] }}</td>
                                                <td class="border border-gray-300 px-4 py-2">
                                                    {{ \Carbon\Carbon::parse($data['entry_time'])->format('H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-gray-500 py-4 italic">
                                                    Belum ada kendaraan parkir hari ini.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

</main>
