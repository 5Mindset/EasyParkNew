<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Easy Park Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
</head>

<body class="min-h-screen flex">
    <!-- Left section -->
    <div class="w-[55%] min-h-screen relative flex flex-col justify-center items-start px-16 py-20 overflow-hidden text-white"
        style="background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80') no-repeat center center/cover;">
        
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        
        <!-- Content -->
        <img src="images/logo.png" alt="Easy Park logo" class="w-36 mb-8 z-10 relative" />
        <h1 class="text-4xl font-extrabold mb-4 drop-shadow-lg max-w-md z-10 relative">
            Selamat Datang di Easy Park!
        </h1>
        <p class="text-lg mb-8 max-w-md leading-relaxed drop-shadow-md z-10 relative">
            Nikmati layanan parkir kami yang luas, aman, dan strategis. Parkir jadi lebih mudah dan nyaman dengan Easy Park.
        </p>
        <button
            class="bg-[#0086FF] text-white font-semibold rounded-full py-3 px-10 shadow-lg hover:bg-[#0065d1] transition-colors drop-shadow-md z-10 relative">
            Pelajari Lebih Lanjut
        </button>
    </div>

    <!-- Right section (slot for login) -->
    <div class="w-[45%] min-h-screen flex flex-col justify-center items-center px-16 bg-white">
        {{ $slot }}
    </div>
</body>

</html>
