@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold mb-3">Daftar Mahasiswa</h4>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <a href="{{ route('students.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i>
            <span>Tambah Mahasiswa</span>
        </a>

        <form action="{{ route('students.index') }}" method="GET" class="position-relative"
            style="max-width: 250px; width: 100%;">
            <input type="text" name="search" class="form-control ps-5" placeholder="Cari mahasiswa..."
                value="{{ request('search') }}">
            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
        </form>
    </div>

    <div class="card border-0 shadow rounded-4 mb-4">
        <div class="card-body p-4">
            @if ($students->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Foto</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $index => $student)
                        <tr>
                            <td>{{ $students->firstItem() + $index }}</td>
                            <td>
                                <div style="width: 50px; height: 50px;">
                                    @if ($student->image)
                                    <img src="{{ asset('storage/' . $student->image) }}" alt="Foto"
                                        class="rounded-circle w-100 h-100 object-fit-cover">
                                    @else
                                    <div
                                        class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-semibold">{{ $student->full_name }}</td>
                            <td>{{ $student->nim }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone_number ?? '-' }}</td>
                            <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td>{{ $student->address ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>

                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="delete-form">
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
                {{ $students->withQueryString()->links('pagination::tailwind') }}
            </div>
            @else
            <div class="text-center text-muted py-4">
                <i class="bi bi-info-circle fs-4"></i>
                <p class="mt-2 mb-0">Tidak ada data mahasiswa yang ditemukan.</p>
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
                title: 'Yakin ingin menghapus mahasiswa ini?',
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
