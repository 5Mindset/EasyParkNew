<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
{
    // Lakukan autentikasi
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // Hanya izinkan admin untuk login via web
    if ($user->role === 'admin') {
        return redirect()
            ->route('dashboard')
            ->with('success', 'Selamat datang, Admin! Anda berhasil login.');
    }

    // Logout untuk non-admin
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()
        ->route('login')
        ->with('error', 'Hanya admin yang dapat login melalui web. Silakan gunakan aplikasi mobile untuk role petugas dan mahasiswa.');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
