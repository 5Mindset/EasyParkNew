@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-2">
        <h3 class="fw-bold">Ubah Password</h3>
        <p class="text-muted small mb-0">
            <a href="{{ route('profile.index') }}" class="text-decoration-none text-muted">Profil</a>
            <span class="mx-1">/</span>
            <span class="text-primary fw-semibold">Ubah Password</span>
        </p>
    </div>

    <div class="card border-0 shadow rounded-4">
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.updatePassword') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    <i class="bi bi-lock"></i> Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
