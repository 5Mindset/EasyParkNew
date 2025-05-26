@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul --}}
        <h4 class="fw-bold mb-3">Daftar Kendaraan</h4>

        {{-- Baris: Tambah dan Search --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            {{-- Tombol Tambah --}}
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Kendaraan</span>
            </a>

            {{-- Form Search --}}
            <form action="{{ route('vehicles.index') }}" method="GET" class="position-relative"
                style="max-width: 250px; width: 100%;">
                <input type="text" name="search" class="form-control ps-5" placeholder="Cari plat nomor..."
                    value="{{ request('search') }}">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                @if ($vehicles->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Plat Nomor</th>
                                    <th>Model</th>
                                    <th>Merk</th>
                                    <th>Jenis</th>
                                    <th>Pemilik</th>
                                    <th>STNK</th>
                                    <th style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicles as $index => $vehicle)
                                    <tr>
                                        <td>{{ $vehicles->firstItem() + $index }}</td>
                                        <td class="fw-semibold">{{ $vehicle->plate_number }}</td>
                                        <td>{{ $vehicle->model->name ?? '-' }}</td>
                                        <td>{{ $vehicle->model->vehicleBrand->name ?? '-' }}</td>
                                        <td>{{ $vehicle->model->vehicleBrand->vehicleType->name ?? '-' }}</td>
                                        <td>{{ $vehicle->user->name ?? '-' }}</td>
                                        <td>
                                            @if ($vehicle->stnk_image)
                                                <img src="{{ asset('storage/' . $vehicle->stnk_image) }}" alt="STNK" width="70">
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger btn-delete" type="button">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $vehicles->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p class="mt-2 mb-0">Tidak ada data kendaraan yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Flash message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: @json(session('error')),
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @endif

    // Konfirmasi hapus
    $(document).ready(function () {
        $('.btn-delete').click(function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus kendaraan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
