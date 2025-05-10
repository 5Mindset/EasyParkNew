<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Easy Park</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-[#053a7c]">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-[#053a7c] shadow z-50">
        <div class="max-w-[1280px] mx-auto px-6 sm:px-10 lg:px-16 flex items-center justify-between py-6">
            <div class="flex items-center space-x-2">
                <img alt="Easy Park logo" class="w-[180px] h-[40px] object-contain" src="/images/logo.png" width="180" height="40"  
                    height="40" />
            </div>
    
            <nav>
                <ul class="hidden md:flex items-center space-x-8 text-white text-sm font-normal">
                    <li><a class="hover:underline" href="#beranda">Beranda</a></li>
                    <li><a class="hover:underline" href="#tentang-kami">Tentang kami</a></li>
                    <li><a class="hover:underline" href="#keunggulan">Keunggulan</a></li>
                    <li><a class="hover:underline" href="#fitur">Fitur</a></li>
                    <li><a class="hover:underline" href="#hubungi-kami">Hubungi Kami</a></li>
                    <li>
                        <a class="border border-white rounded-lg px-5 py-2 text-white hover:bg-white hover:text-[#053a7c] transition-colors duration-300"
                            href="#">Download App</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    
 <!-- Hero Section -->
<!-- Hero Section -->
<main id="beranda"
    class="pt-40 max-w-[1280px] mx-auto px-6 sm:px-10 lg:px-16 flex flex-col md:flex-row items-center justify-between min-h-[480px] relative z-10">
    <div class="text-white max-w-xl md:max-w-lg lg:max-w-xl">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 leading-tight">Easy Park</h1>
        <p class="text-sm sm:text-base mb-8 max-w-md">Nikmati layanan parkir kami yang luas, aman, dan strategis.</p>
        <a class="inline-flex items-center bg-blue-600 hover:bg-blue-700 transition-colors duration-300 rounded-md px-6 py-3 text-white text-sm sm:text-base font-medium"
            href="#">
            Hubungi Kami
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <div class="mt-10 md:mt-0">
        <img alt="Mobil Putih" class="w-[600px] max-w-full h-auto" src="/images/mobilputih.png" width="600"
            height="400" />
    </div>
</main>


    <!-- Wave -->
    <div class="relative -mt-36">
        <!-- -mt-36 supaya wave lebih ke atas lagi -->
        <svg class="w-full" fill="white" preserveAspectRatio="none" viewBox="0 0 1440 220"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0,160 C480,40 960,280 1440,160 L1440,320 L0,320 Z" fill="white"></path>
        </svg>
    </div>
    <!-- Middle Section -->
    <section id="tentang-kami" class="bg-white text-gray-900 py-12"> 
        <div class="max-w-7xl mx-auto px-6">
            <section class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-12">
                <div class="flex justify-center md:justify-start">
                    <img alt="Illustration of an orange van stopped at a parking barrier with a security guard holding a phone, city buildings and trees in the background"
                        class="w-full max-w-[600px] h-auto" src="/images/parkinglot.png" width="600"
                        height="300" />
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">Easy Park</h1>
                    <p class="text-sm sm:text-base leading-relaxed max-w-md mx-auto md:mx-0 mb-6">EasyPark adalah
                        aplikasi parkir khusus untuk mahasiswa dan civitas akademika yang membutuhkan tempat parkir
                        aman, strategis, dan terjangkau di sekitar kampus. Dengan lokasi parkir hanya beberapa langkah
                        dari kampus, EasyPark bikin urusan parkir jadi lebih mudah dan nyaman.</p>
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white text-base font-medium py-3 px-8 rounded-lg transition flex items-center justify-center mx-auto md:mx-0"
                        type="button">
                        Mulai
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </section>
            <section class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Bekerja Sama</h2>
                    <p class="text-sm sm:text-base leading-relaxed max-w-md mx-auto md:mx-0 mb-6">"Sebagai bentuk
                        komitmen dalam mendukung transformasi digital di lingkungan pendidikan, Easy Park memperpanjang
                        kerja sama dengan Koordinator Politeknik Negeri Jember Kampus 2 Bondowoso untuk
                        mengimplementasikan sistem parkir cerdas yang efisien, aman, dan terintegrasi."</p>
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white text-base font-medium py-3 px-8 rounded-lg transition flex items-center justify-center mx-auto md:mx-0"
                        type="button">
                        Mulai
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
                <div class="flex justify-center md:justify-end pr-6">
                    <img alt="Logo Kerjasama" class="w-full max-w-[500px] h-auto" src="/images/bekerjasama.png"
                        width="500" height="500" />
                </div>
            </section>
        </div>
    </section>
    <!-- Keunggulan Kami Section -->
    <section id="keunggulan" class="bg-[#073b82] text-white">
        <div
            class="max-w-7xl mx-auto px-6 py-16 flex flex-col-reverse md:flex-row items-center md:items-start gap-10 md:gap-0">
            <div class="md:w-1/2 text-center md:text-left">
                <h2 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">Keunggulan Kami</h2>
                <p class="text-sm md:text-base leading-relaxed max-w-md mx-auto md:mx-0 mb-8">"EasyPark menghadirkan
                    solusi parkir cerdas dengan fitur QR Code untuk identifikasi pengguna. Dengan sistem ini, proses
                    masuk dan keluar area parkir menjadi lebih cepat, aman, dan efisien tanpa perlu kontak fisik.
                    Teknologi ini juga membantu mengurangi antrian dan meminimalisir pemalsuan identitas."</p>
                <button
                    class="bg-[#4a90e2] hover:bg-[#3a78d1] transition-colors duration-300 rounded px-5 py-2.5 text-sm md:text-base font-medium flex items-center gap-2"
                    type="button">
                    Let's Go
                    <svg aria-hidden="true" class="w-4 h-4" fill="none" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </div>
            <div class="md:w-1/2 flex justify-center md:justify-end">
                <img alt="Ilustrasi mobil parkir" class="w-full max-w-[600px] h-auto" src="/images/car.png"
                    width="600" height="350" loading="lazy" />
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan Section -->
    <section id="fitur" class="bg-white text-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-center text-2xl md:text-3xl font-extrabold mb-14 leading-tight max-w-lg mx-auto">
                Fitur unggulan aplikasi kami
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-y-12 gap-x-8 text-center max-w-6xl mx-auto">

                <!-- Dashboard Interaktif -->
                <div class="flex flex-col items-center px-4">
                    <div class="bg-[#4a90e2] rounded-full p-6 mb-5 inline-flex">
                        <img alt="Ikon smartphone" class="w-12 h-12 object-contain" src="/images/smartphone.png"
                            width="48" height="48" loading="lazy" />
                    </div>
                    <h4 class="font-bold text-sm md:text-base mb-2">Dashboard Interaktif</h4>
                    <p class="text-xs md:text-sm max-w-[180px]">
                        Menampilkan data real-time aktivitas parkir: jumlah kendaraan, status area, dan kinerja petugas.
                    </p>
                </div>

                <!-- Riwayat Kendaraan -->
                <div class="flex flex-col items-center px-4">
                    <div class="bg-[#4a90e2] rounded-full p-6 mb-5 inline-flex">
                        <img alt="Ikon riwayat kendaraan" class="w-12 h-12 object-contain" src="/images/histori.png"
                            width="48" height="48" loading="lazy" />
                    </div>
                    <h4 class="font-bold text-sm md:text-base mb-2">Riwayat Kendaraan</h4>
                    <p class="text-xs md:text-sm max-w-[180px]">
                        Mencatat otomatis riwayat keluar-masuk kendaraan lengkap dengan waktu, plat nomor, dan status.
                    </p>
                </div>

                <!-- Kode QR Kendaraan -->
                <div class="flex flex-col items-center px-4">
                    <div class="bg-[#4a90e2] rounded-full p-6 mb-5 inline-flex">
                        <img alt="Ikon kode QR kendaraan" class="w-12 h-12 object-contain" src="/images/QrCode.png"
                            width="48" height="48" loading="lazy" />
                    </div>
                    <h4 class="font-bold text-sm md:text-base mb-2">Kode QR Kendaraan</h4>
                    <p class="text-xs md:text-sm max-w-[180px]">
                        Setiap kendaraan diberi QR unik untuk mempercepat verifikasi saat masuk dan keluar.
                    </p>
                </div>

                <!-- Manajemen Kendaraan -->
                <div class="flex flex-col items-center px-4">
                    <div class="bg-[#4a90e2] rounded-full p-6 mb-5 inline-flex">
                        <img alt="Ikon manajemen kendaraan" class="w-12 h-12 object-contain" src="/images/upload.png"
                            width="48" height="48" loading="lazy" />
                    </div>
                    <h4 class="font-bold text-sm md:text-base mb-2">Manajemen Kendaraan</h4>
                    <p class="text-xs md:text-sm max-w-[180px]">
                        Pengguna dapat mendaftarkan dan mengelola data kendaraan, termasuk plat, jenis, dan foto STNK.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- contact us -->
    </section>
    <section class="text-center px-4 py-12 max-w-7xl mx-auto">
        <h1 class="font-extrabold text-3xl sm:text-4xl md:text-5xl leading-tight text-white">
            Apa Tujuan Aplikasi Ini Di Buat,!!
        </h1>
        <p class="mt-3 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed font-normal text-white">
            Aplikasi ini dibuat untuk mempermudah mahasiswa dalam mengakses area parkir kampus secara cepat, aman, dan
            efisien menggunakan teknologi QR code.
        </p>
    </section>
    <!-- Middle Section -->
    <section class="bg-white text-black relative overflow-hidden"
        style="background-image: url('/images/Element.png'); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div
            class="max-w-7xl mx-auto px-4 py-16 flex flex-col lg:flex-row items-center lg:items-start gap-12 lg:gap-24">
            <!-- Left side with single photo shifted right -->
            <div class="relative flex justify-center lg:justify-start w-full lg:w-1/2">
                <img alt="Ilustrasi aplikasi EasyPark" class="max-w-md w-full h-auto ml-auto" src="/images/apps.png"
                    width="400" height="400" style="" />
            </div>

            <!-- Right side text and button -->
            <div class="w-full lg:w-1/2 max-w-xl">
                <h2 class="font-extrabold text-3xl sm:text-4xl leading-tight mb-4">
                    Parkir Cepat, Tanpa Ribet Tinggal Scan, Langsung Jalan!
                </h2>
                <p class="text-xs sm:text-sm leading-relaxed mb-6">
                    Dengan sistem E-Parkir berbasis QR Code, proses masuk dan keluar area parkir menjadi lebih cepat dan
                    efisien tanpa perlu kartu parkir atau interaksi langsung. Teknologi ini menghadirkan solusi modern
                    yang aman, praktis, dan cocok untuk lingkungan kampus yang dinamis.
                </p>
                <button
                    class="bg-[#5a9dff] text-white text-xs sm:text-sm font-medium px-5 py-2 rounded-md flex items-center gap-2 hover:bg-[#3a7de8] transition"
                    type="button">
                    Read more
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Bottom Section -->
    <section id="hubungi-kami" class="bg-[#043a7c] px-4 py-12 max-w-7xl mx-auto">
        <h3 class="font-extrabold text-lg sm:text-xl mb-1 text-white">
            HUBUNGI KAMI SEKARANG
        </h3> 
        <p class="text-[9px] sm:text-xs mb-6 uppercase font-normal text-white">
            HUBUNGI KAMI JIKA ANDA INGIN MENGELUH ATAU MELAKUKAN URUSAN
        </p>
        <form action="#" class="bg-white rounded-3xl p-8 max-w-5xl mx-auto flex flex-col lg:flex-row gap-8"
            method="POST">
            <div class="flex flex-col gap-6 w-full lg:w-1/2">
                <div class="flex gap-6 items-center">
                    <label class="flex items-center gap-2 text-xs sm:text-sm cursor-pointer">
                        <input checked="" class="w-4 h-4 text-[#5a9dff] border-gray-300 focus:ring-[#5a9dff]"
                            name="contactType" type="radio" value="sayHi" />
                        Say Hi
                    </label>
                    <label class="flex items-center gap-2 text-xs sm:text-sm cursor-pointer">
                        <input class="w-4 h-4 text-[#5a9dff] border-gray-300 focus:ring-[#5a9dff]" name="contactType"
                            type="radio" value="getQuote" />
                        Get a Quote
                    </label>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs sm:text-sm text-black font-normal" for="name">
                        Nama
                    </label>
                    <input
                        class="border border-gray-400 rounded-md px-3 py-2 text-xs sm:text-sm text-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#5a9dff]"
                        id="name" name="name" placeholder="Name" type="text" />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs sm:text-sm text-black font-normal" for="email">
                        Email*
                    </label>
                    <input
                        class="border border-gray-400 rounded-md px-3 py-2 text-xs sm:text-sm text-black placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#5a9dff]"
                        id="email" name="email" placeholder="Email" required="" type="email" />
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs sm:text-sm text-black font-normal" for="message">
                        Pesan*
                    </label>
                    <textarea
                        class="border border-gray-400 rounded-md px-3 py-2 text-xs sm:text-sm text-black placeholder:text-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-[#5a9dff]"
                        id="message" name="message" placeholder="Message" required="" rows="5"></textarea>
                </div>
                <button
                    class="bg-[#5a9dff] text-white text-xs sm:text-sm font-medium rounded-md py-2 mt-2 hover:bg-[#3a7de8] transition"
                    type="submit">
                    Kirim Pesan
                </button>
            </div>
            <div class="w-full lg:w-1/2 flex justify-center items-center">
                <img alt="Illustration of a megaphone with social media icons around it in black and blue colors"
                    class="max-w-full h-auto" height="250"
                    src="https://storage.googleapis.com/a1aa/image/18e28aaa-2163-44da-2e50-57b9aa13d30a.jpg"
                    width="300" />
            </div>
        </form>
    </section>
</body>

</html>


<!-- Testimonial Section -->
<section class="bg-[#043a7c] px-4 py-12 max-w-7xl mx-auto text-white">
    <h2 class="text-center font-extrabold text-3xl md:text-4xl mb-12">Apa Yg Client Kami Katakan?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-lg shadow p-8 text-gray-900">
            <i class="fas fa-quote-left text-[#0F3B7D] text-4xl font-extrabold"></i>
            <p class="mt-4 text-sm">Whitepate is designed as a collaboration tool for businesses that is a full project
                management solution.</p>
            <hr class="border-t border-gray-300 my-6" />
            <div class="flex items-center space-x-4">
                <img class="w-12 h-12 rounded-full object-cover"
                    src="https://storage.googleapis.com/a1aa/image/1929e13b-424a-4baf-597b-4a96ec91d44e.jpg"
                    alt="Client 1" />
                <div>
                    <p class="font-semibold text-sm">Siti Nuril Azizah</p>
                    <p class="text-[9px]">Head of Talent Acquisition, North America</p>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-[#4A90E2] rounded-lg p-8 text-white">
            <i class="fas fa-quote-left text-white text-4xl font-extrabold"></i>
            <p class="mt-4 text-xs">Whitepate is designed as a collaboration tool for businesses that is a full project
                management solution.</p>
            <hr class="border-t border-white/40 my-6" />
            <div class="flex items-center space-x-4">
                <img class="w-12 h-12 rounded-full object-cover"
                    src="https://storage.googleapis.com/a1aa/image/7a8622c8-640a-4350-dee2-be652d61d04d.jpg"
                    alt="Client 2" />
                <div>
                    <p class="font-semibold text-sm">Bustanul Arifin</p>
                    <p class="text-[9px]">Head of Talent Acquisition, North America</p>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="bg-[#4A90E2] rounded-lg p-8 text-white">
            <i class="fas fa-quote-left text-white text-4xl font-extrabold"></i>
            <p class="mt-4 text-xs">Whitepate is designed as a collaboration tool for businesses that is a full project
                management solution.</p>
            <hr class="border-t border-white/40 my-6" />
            <div class="flex items-center space-x-4">
                <img class="w-12 h-12 rounded-full object-cover"
                    src="https://storage.googleapis.com/a1aa/image/6034daaa-df8f-44c1-afb8-82d5a6a4d353.jpg"
                    alt="Client 3" />
                <div>
                    <p class="font-semibold text-sm">Raihan Arum Rais</p>
                    <p class="text-[9px]">Head of Talent Acquisition, North America</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer Section -->
</section>
<footer class="bg-[#043A7C] text-white pt-16 pb-10">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="font-extrabold text-3xl leading-tight max-w-3xl mx-auto">
            Bekerja Sama Dengan Polije Kampus
            <br />
            2 Bondowoso
        </h2>
        <p class="mt-3 text-sm max-w-md mx-auto">
            Ayo mulai bekerja sama dengan kami
        </p>
        <button aria-label="Try Taskey free"
            class="mt-6 bg-[#4A90E2] text-white text-xs px-5 py-2 rounded hover:bg-[#3a7bd5] transition flex items-center justify-center mx-auto">
            Try Taskey free
            <i class="fas fa-arrow-right ml-2">
            </i>
        </button>
        <p class="mt-6 text-xs max-w-xs mx-auto">
            On a big team? Contact sales
        </p>
        <div class="mt-6 flex justify-center">
            <img alt="Logo Politeknik Negeri Jember" class="h-16 object-contain" src="/images/polije.png"
                width="auto" height="64" />
        </div>

    </div>
    <div
        class="max-w-7xl mx-auto px-6 mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8 text-[9px] leading-tight">
        <div>
            <p class="font-bold mb-3">
                ABOUT US
            </p>
            <p>
                KAMI ADALAH TIM PENGEMBANG YANG BERFOKUS MENGHADIRKAN SISTEM PARKIR CERDAS BERBASIS QR CODE DI
                LINGKUNGAN KAMPUS, TANPA PERLU KARTU FISIK ATAU ANTRE PANJANG—CUKUP DENGAN APLIKASI INI, PARKIR MENJADI
                LEBIH PRAKTIS DAN EFISIEN.
            </p>
        </div>
        <div>
            <p class="font-bold mb-3">
                NAVIGATION
            </p>
            <ul class="space-y-1 text-[#AFC1D6]">
                <li>
                    BERANDA
                </li>
                <li>
                    TENTANG KAMI
                </li>
                <li>
                    KEUNGGULAN
                </li>
                <li>
                    FITUR
                </li>
                <li>
                    HUBUNGI KAMI
                </li>
            </ul>
        </div>
        <div>
            <p class="font-bold mb-3">
                SERVICE
            </p>
            <ul class="space-y-1 text-[#AFC1D6]">
                <li>
                    LOGIN AMAN UNTUK MAHASISWA
                </li>
                <li>
                    RIWAYAT PARKIR OTOMATIS
                </li>
                <li>
                    MENGGUNAKAN QR CODE UNTUK MASUK DAN KELUAR
                </li>
            </ul>
        </div>
        <div>
            <p class="font-bold mb-3">
                OUR BLOG
            </p>
            <ul class="space-y-1 text-[#AFC1D6]">
                <li>
                    POLIJE.AC.ID
                </li>
                <li>
                    PARK LOT POLIJE POLICY
                </li>
                <li>
                    POLIJE BONDOWOSO
                </li>
            </ul>
        </div>
        <div>
            <p class="font-bold mb-3">
                CONTACT US
            </p>
            <p class="text-[#AFC1D6]">
                Alif Chandra Darmawan
                <br />
                Jl. Raya Situbondo, Blindungan, Kec. Bondowoso, Kabupaten Bondowoso, Jawa Timur 68211
                <br />
                +62 859-6441-6174
            </p>
        </div>
    </div>
    <div
        class="max-w-7xl mx-auto px-6 mt-12 flex flex-col sm:flex-row justify-between items-center text-[10px] text-[#AFC1D6]">
        <div class="flex items-center space-x-4 mb-4 sm:mb-0">
            <div class="flex items-center space-x-1 cursor-pointer">
                <i class="fas fa-globe">
                </i>
                <span>
                    English
                </span>
                <i class="fas fa-chevron-down text-[8px]">
                </i>
            </div>
            <span>
                Terms &amp; privacy
            </span>
            <span>
                Keamanan
            </span>
            <span>
                Status
            </span>
            <span>
                ©2025 Kelmpok 4 .
            </span>
        </div>
        <div class="flex space-x-6 text-white text-sm">
            <a aria-label="Facebook" class="hover:text-[#4A90E2] transition" href="#">
                <i class="fab fa-facebook-f">
                </i>
            </a>
            <a aria-label="Twitter" class="hover:text-[#4A90E2] transition" href="#">
                <i class="fab fa-twitter">
                </i>
            </a>
            <a aria-label="LinkedIn" class="hover:text-[#4A90E2] transition" href="#">
                <i class="fab fa-linkedin-in">
                </i>
            </a>
        </div>
    </div>
</footer>


</body>

</html>
