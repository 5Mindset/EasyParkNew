@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-3">Daftar Jenis Kendaraan</h4>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <a href="{{ route('vehicle-types.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Jenis</span>
        </a>

        <form action="{{ route('vehicle-types.index') }}" method="GET" class="position-relative"
            style="max-width: 250px; width: 100%;">
            <input type="text" name="search" class="form-control ps-5" placeholder="Cari jenis kendaraan..."
                value="{{ request('search') }}">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        </form>
    </div>

    <div class="card border-0 shadow rounded-4 mb-4">
        <div class="card-body p-4">
            @if ($vehicleTypes->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Nama Jenis</th>
                            <th>Ukuran Area (m²)</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicleTypes as $index => $type)
                        <tr>
                            <td>{{ $vehicleTypes->firstItem() + $index }}</td>
                            <td class="fw-semibold">{{ $type->name }}</td>
                            <td>{{ $type->area_size ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('vehicle-types.edit', $type->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    {{-- Form hapus tanpa onsubmit --}}
                                    <form action="{{ route('vehicle-types.destroy', $type->id) }}" method="POST" class="delete-form">
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

            <div class="mt-3">
                {{ $vehicleTypes->withQueryString()->links('pagination::tailwind') }}
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="bi bi-info-circle fs-4"></i>
                <p class="mt-2 mb-0">Tidak ada data jenis kendaraan yang ditemukan.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Handle flash messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    @endif

    // Konfirmasi hapus dengan SweetAlert2
    $(document).ready(function () {
        $('.btn-delete').click(function(e) {
            e.preventDefault();

            const form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus jenis ini?',
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
