<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>

    @include('partials.sidebar')   {{-- Sidebar kiri --}}
    @include('partials.navbar')    {{-- Header / Topbar --}}

    <main id="main" class="main">
        @yield('content')
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    @include('partials.scripts')   {{-- File JS --}}
    
</body>
</html>
