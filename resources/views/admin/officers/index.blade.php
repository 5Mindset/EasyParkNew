@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul --}}
        <h4 class="fw-bold mb-3">Daftar Petugas</h4>

        {{-- Baris: Tambah dan Search --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            {{-- Tombol Tambah --}}
            <a href="{{ route('officers.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i>
                <span>Tambah Petugas</span>
            </a>

            {{-- Form Search --}}
            <form action="{{ route('officers.index') }}" method="GET" class="position-relative"
                style="max-width: 250px; width: 100%;">
                <input type="text" name="search" class="form-control ps-5" placeholder="Cari petugas..."
                    value="{{ request('search') }}">
                <i class="bi bi-search-heart position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
            </form>
        </div>

        {{-- Alert sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                @if ($officers->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIP</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($officers as $index => $officer)
                                    <tr>
                                        <td>{{ $officers->firstItem() + $index }}</td>
                                        <td>
                                            <div style="width: 50px; height: 50px;">
                                                @if ($officer->image)
                                                    <img src="{{ asset('storage/' . $officer->image) }}" alt="Foto"
                                                        class="rounded-circle w-100 h-100 object-fit-cover">
                                                @else
                                                    <div
                                                        class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">
                                                        <i class="bi bi-person-circle"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="fw-semibold">{{ $officer->full_name }}</td>
                                        <td>{{ $officer->nim }}</td>
                                        <td>{{ $officer->email }}</td>
                                        <td>{{ $officer->phone_number ?? '-' }}</td>
                                        <td>{{ $officer->date_of_birth ? \Carbon\Carbon::parse($officer->date_of_birth)->translatedFormat('d M Y') : '-' }}
                                        </td>
                                        <td>{{ $officer->address ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- Aksi Lihat --}}
                                                <a href="{{ route('officers.show', $officer->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>

                                                {{-- Aksi Edit --}}
                                                <a href="{{ route('officers.edit', $officer->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>

                                                {{-- Aksi Hapus --}}
                                                <form action="{{ route('officers.destroy', $officer->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">
                                                        <i class="bi bi-trash3-fill"></i>
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
                        {{ $officers->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                        <p class="mt-2 mb-0">Tidak ada data petugas yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
