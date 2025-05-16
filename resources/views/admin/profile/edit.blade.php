@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="mb-2">
            <h3 class="fw-bold">Edit Profil Saya</h3>
            <p class="text-muted small mb-0">
                <a href="{{ route('profile.index') }}" class="text-decoration-none text-muted">Profil</a>
                <span class="mx-1">/</span>
                <span class="text-primary fw-semibold">Edit Profil</span>
            </p>
        </div>

        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4 align-items-center">
                        {{-- Foto Profil --}}
                        <div class="col-md-3 text-center">
                            <div style="width: 150px; height: 150px; margin: 0 auto;">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="Foto Profil"
                                        class="rounded-circle w-100 h-100 object-fit-cover">
                                @else
                                    <div
                                        class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">
                                        <i class="bi bi-person-fill fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-3">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- Detail Informasi Profil --}}
                        <div class="col-md-9">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone_number" class="form-label">No. HP</label>
                                <input type="text" name="phone_number"
                                    value="{{ old('phone_number', $user->phone_number) }}" class="form-control" />
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
