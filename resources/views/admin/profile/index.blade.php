@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="mb-2">
            <h3 class="fw-bold">Profil Saya</h3>
            <p class="text-muted small mb-0">
                <span class="text-primary fw-semibold">Profil</span>
            </p>
        </div>

        <div class="card border-0 shadow rounded-4">
            <div class="card-body p-4">
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
                    </div>

                    {{-- Detail Informasi Profil --}}
                    <div class="col-md-9">
                        <h4 class="fw-bold mb-3">{{ $user->name }}</h4>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <strong>Email:</strong><br>
                                {{ $user->email }}
                            </div>
                            <div class="col-md-6 mb-2">
                                <strong>No. HP:</strong><br>
                                {{ $user->phone_number ?? '-' }}
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3 me-2">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>

                        <a href="{{ route('profile.password.edit') }}" class="btn btn-warning mt-3">
                            <i class="bi bi-lock"></i> Ubah Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
