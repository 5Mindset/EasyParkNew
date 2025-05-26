<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.head')
    <!-- SweetAlert2 dan jQuery jika diperlukan -->
</head>

<body>

    @include('partials.sidebar')
    @include('partials.navbar')

    <main id="main" class="main">
        @yield('content')
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    {{-- Include JS umum --}}
    @include('partials.scripts')

    {{-- SweetAlert2 CDN (boleh dihapus jika sudah dimuat di partials.scripts) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Notifikasi flash message jika ada (opsional, bisa juga ditaruh di halaman masing-masing) --}}
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: @json($errors->first()),
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    {{-- Script tambahan dari halaman --}}
    @yield('scripts')

</body>

</html>
