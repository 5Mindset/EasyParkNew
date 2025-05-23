@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h4 class="fw-bold mb-3">Riwayat Parkir Kendaraan Mahasiswa</h4>

        <div class="d-flex justify-content-end flex-wrap gap-2 mb-3">
            {{-- Filter Status --}}
            <form action="{{ route('parking-records.index') }}" method="GET">
                <select name="status" class="form-select" style="width: 160px" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="parked" {{ request('status') == 'parked' ? 'selected' : '' }}>Parkir</option>
                    <option value="left" {{ request('status') == 'left' ? 'selected' : '' }}>Keluar</option>
                </select>
                <input type="hidden" name="vehicle_type_id" value="{{ request('vehicle_type_id') }}">
            </form>

            {{-- Filter Jenis Kendaraan --}}
            <form action="{{ route('parking-records.index') }}" method="GET">
                <select name="vehicle_type_id" class="form-select" style="width: 180px" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    @foreach ($vehicleTypes as $type)
                        <option value="{{ $type->id }}" {{ request('vehicle_type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="status" value="{{ request('status') }}">
            </form>

            {{-- Tombol Cetak PDF --}}
            <a href="{{ route('parking-records.exportPdf', request()->query()) }}" target="_blank" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                @if ($parkingRecords->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Plat Nomor</th>
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Jenis</th>
                                    <th>Mahasiswa</th>
                                    <th>Status</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($parkingRecords as $index => $record)
                                    <tr>
                                        <td>{{ $parkingRecords->firstItem() + $index }}</td>
                                        <td class="fw-semibold">{{ $record->vehicle->plate_number ?? '-' }}</td>
                                        <td>{{ $record->vehicle->model->vehicleBrand->name ?? '-' }}</td>
                                        <td>{{ $record->vehicle->model->name ?? '-' }}</td>
                                        <td>{{ $record->vehicle->model->vehicleType->name ?? '-' }}</td>
                                        <td>{{ $record->vehicle->user->name ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $record->status === 'parked' ? 'success' : 'secondary' }}">
                                                {{ $record->status === 'parked' ? 'Parkir' : 'Keluar' }}
                                            </span>
                                        </td>
                                        <td>{{ $record->entry_time }}</td>
                                        <td>{{ $record->exit_time ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('parking-records.show', $record->id) }}"
                                                class="btn btn-sm btn-info" aria-label="Lihat detail parkir">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $parkingRecords->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p class="mt-2 mb-0">Tidak ada data parkir yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
