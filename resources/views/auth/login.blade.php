<x-guest-layout>
    <h1 class="text-[#222222] font-bold text-2xl mb-2">Hallo selamat datang!!</h1>
    <p class="text-[#555555] text-sm mb-8 max-w-xs text-center">Mari mulai memakirkan kendaraan anda bersama kami</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="w-full max-w-xs flex flex-col gap-4" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="relative">
            <input name="email" type="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus
                class="w-full border border-gray-300 rounded-full py-3 pl-12 pr-4 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#0086FF]" />
            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-xs" />
        </div>

        <!-- Password -->
        <div class="relative">
            <input id="password" name="password" type="password" placeholder="Password" required
                class="w-full border border-gray-300 rounded-full py-3 pl-12 pr-10 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#0086FF]" />
            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

            <!-- Eye Icon -->
            <button type="button" onclick="togglePassword()"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 focus:outline-none">
                <i id="eyeIcon" class="fas fa-eye"></i>
            </button>

            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-2 text-sm text-gray-600">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ml-2">Remember me</span>
            </label>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="bg-[#0086FF] text-white rounded-full py-3 text-center text-sm font-normal hover:bg-[#0072e6] transition-colors">
            Masuk
        </button>

    </form>
</x-guest-layout>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
