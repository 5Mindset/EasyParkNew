@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul --}}
        <h4 class="fw-bold mb-3">Daftar Area Parkir</h4>

        {{-- Baris: Search --}}
        <div class="d-flex justify-content-end align-items-center mb-4 flex-wrap gap-3">
            {{-- Form Search --}}
            <form action="{{ route('parking-areas.index') }}" method="GET" class="position-relative"
                style="max-width: 250px; width: 100%;">
                <input type="text" name="search" class="form-control ps-5" placeholder="Cari nama area..."
                    value="{{ request('search') }}">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </form>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Alert error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                @if ($parkingAreas->count())
                    @php
                        // Cek apakah ada area terkunci
                        $hasLockedArea = $parkingAreas
                            ->filter(function ($area) {
                                return $area->parkingRecords()->where('status', 'parked')->exists();
                            })
                            ->isNotEmpty();
                    @endphp

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Nama Area</th>
                                    <th>Maks. Area (m²)</th>
                                    <th style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parkingAreas as $index => $area)
                                    <tr>
                                        <td>{{ $parkingAreas->firstItem() + $index }}</td>
                                        <td class="fw-semibold">{{ $area->name }}</td>
                                        <td>{{ $area->max_area }}</td>
                                        <td>
                                            @php
                                                $isLocked = $area
                                                    ->parkingRecords()
                                                    ->where('status', 'parked')
                                                    ->exists();
                                            @endphp

                                            @if ($isLocked)
                                                <button class="btn btn-sm btn-secondary" disabled
                                                    title="Tidak bisa diedit karena ada kendaraan sedang parkir">
                                                    <i class="bi bi-lock-fill"></i> Terkunci
                                                </button>
                                            @else
                                                <a href="{{ route('parking-areas.edit', $area->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Catatan hanya muncul jika ada area terkunci --}}
                    @if ($hasLockedArea)
                        <div class="alert alert-info mt-4 mb-0 rounded-4 d-flex align-items-start gap-2" role="alert">
                            <i class="bi bi-exclamation-circle-fill fs-5 mt-1"></i>
                            <div>
                                <strong>Catatan:</strong> Area parkir yang sedang digunakan tidak dapat diedit. Silakan
                                tunggu
                                hingga semua kendaraan keluar untuk dapat mengedit data area tersebut.
                            </div>
                        </div>
                    @endif

                    {{-- Pagination Tailwind --}}
                    <div class="mt-3">
                        {{ $parkingAreas->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p class="mt-2 mb-0">Tidak ada data area parkir yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
