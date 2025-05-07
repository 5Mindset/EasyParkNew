@extends('layouts.app')

@section('content')
    <div class="container py-5">
        {{-- Judul --}}
        <h4 class="fw-bold mb-3">Daftar Merek Kendaraan</h4>

        {{-- Baris: Tambah dan Search --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            {{-- Tombol Tambah --}}
            <a href="{{ route('vehicle-brands.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Merek</span>
            </a>

            {{-- Form Search --}}
            <form action="{{ route('vehicle-brands.index') }}" method="GET" class="position-relative"
                style="max-width: 250px; width: 100%;">
                <input type="text" name="search" class="form-control ps-5" placeholder="Cari merek kendaraan..."
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

        {{-- Tabel --}}
        <div class="card border-0 shadow rounded-4 mb-4">
            <div class="card-body p-4">
                @if ($vehicleBrands->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Nama Merek</th>
                                    <th style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vehicleBrands as $index => $brand)
                                    <tr>
                                        <td>{{ $vehicleBrands->firstItem() + $index }}</td>
                                        <td class="fw-semibold">{{ $brand->name }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('vehicle-brands.edit', $brand->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('vehicle-brands.destroy', $brand->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus merek ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">
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

                    {{-- Pagination Tailwind --}}
                    <div class="mt-3">
                        {{ $vehicleBrands->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-info-circle fs-4"></i>
                        <p class="mt-2 mb-0">Tidak ada data merek kendaraan yang ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
