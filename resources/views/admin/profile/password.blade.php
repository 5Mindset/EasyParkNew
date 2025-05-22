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

                    {{-- Password Saat Ini --}}
                    <div class="mb-3 position-relative">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                            <span class="input-group-text toggle-password" data-target="current_password"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="icon_current_password"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Password Baru --}}
                    <div class="mb-3 position-relative">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                            <span class="input-group-text toggle-password" data-target="new_password"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="icon_new_password"></i>
                            </span>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3 position-relative">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" required>
                            <span class="input-group-text toggle-password" data-target="new_password_confirmation"
                                style="cursor:pointer;">
                                <i class="bi bi-eye-slash" id="icon_new_password_confirmation"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-lock"></i> Simpan Password Baru
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Script di dalam section --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(el) {
            el.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = document.getElementById('icon_' + targetId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            });
        });
    </script>
@endsection
