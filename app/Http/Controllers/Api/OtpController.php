<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OtpController extends Controller
{
    // 1. Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $expiredAt = Carbon::now()->addMinutes(5);

        // Simpan OTP ke database
        OtpCode::create([
            'email' => $request->email,
            'code' => $otp,
            'expired_at' => $expiredAt,
        ]);

        // Kirim email
        Mail::raw("Kode OTP kamu adalah: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Kode OTP Reset Password');
        });

        return response()->json(['message' => 'OTP terkirim ke email']);
    }

    // 2. Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string',
        ]);

        $otp = OtpCode::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expired_at', '>', Carbon::now())
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'OTP tidak valid atau sudah kedaluwarsa'], 422);
        }

        $otp->update(['verified' => true]);

        return response()->json(['message' => 'OTP berhasil diverifikasi']);
    }

    // 3. Ganti password setelah OTP valid
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed', // pakai password_confirmation
        ]);

        $otp = OtpCode::where('email', $request->email)
            ->where('verified', true)
            ->where('expired_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'OTP belum diverifikasi'], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        // Hapus semua OTP untuk email ini
        OtpCode::where('email', $request->email)->delete();

        return response()->json(['message' => 'Password berhasil direset']);
    }
}
