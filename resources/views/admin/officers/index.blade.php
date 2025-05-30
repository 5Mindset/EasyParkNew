@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h4 class="fw-bold mb-3">Daftar Petugas</h4>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <a href="{{ route('officers.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-person-plus"></i>
            <span>Tambah Petugas</span>
        </a>

        <form action="{{ route('officers.index') }}" method="GET" class="position-relative" style="max-width: 250px; width: 100%;">
            <input type="text" name="search" class="form-control ps-5" placeholder="Cari petugas..." value="{{ request('search') }}">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        </form>
    </div>

    <div class="card border-0 shadow rounded-4 mb-4">
        <div class="card-body p-4">
            @if ($officers->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>NIP</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($officers as $index => $officer)
                                <tr>
                                    <td>{{ $officers->firstItem() + $index }}</td>
                                    <td>
                                        <div style="width: 50px; height: 50px;">
                                            @if ($officer->image)
                                                <img src="{{ asset('storage/' . $officer->image) }}" alt="Foto" class="rounded-circle w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="fw-semibold">{{ $officer->full_name }}</td>
                                    <td>{{ $officer->nip }}</td>
                                    <td>{{ $officer->email }}</td>
                                    <td>{{ $officer->phone_number ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('officers.show', $officer->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                            <a href="{{ route('officers.edit', $officer->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="{{ route('officers.destroy', $officer->id) }}" method="POST" class="delete-form">
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
                    {{ $officers->withQueryString()->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center text-muted py-4">
                    <i class="bi bi-info-circle fs-4"></i>
                    <p class="mt-2 mb-0">Tidak ada data petugas yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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

    $(document).ready(function () {
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus petugas ini?',
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
