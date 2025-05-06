<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register API - Daftar user baru dengan role mahasiswa
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nim' => 'required|string|unique:users,nim',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 3, // default mahasiswa
            'nim' => $request->nim,
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil sebagai Mahasiswa!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'redirect_to' => '/login'
        ], 201);
    }


    /**
     * Login API - Menghasilkan Token dan Redirect Role
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $role_id = $user->role_id;
        $role_message = '';
        $redirect_to = '';

        switch ($role_id) {
            case 1:
                $role_message = 'Selamat datang Admin!';
                $redirect_to = 'adminHome';
                break;
            case 2:
                $role_message = 'Halo Petugas, selamat bertugas!';
                $redirect_to = 'petugasHome';
                break;
            case 3:
                $role_message = 'Halo Mahasiswa, selamat datang!';
                $redirect_to = 'mahasiswaHome';
                break;
            default:
                $role_message = 'Selamat datang!';
                $redirect_to = 'home';
                break;
        }

        return response()->json([
            'message' => $role_message,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'redirect_to' => $redirect_to
        ]);
    }

    /**
     * Logout API - Hapus token saat ini
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout dari perangkat ini'
        ]);
    }

    /**
     * Logout dari semua perangkat
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Berhasil logout dari semua perangkat'
        ]);
    }

    /**
     * Update Profile API - Update data umum user
     */
    public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => 'sometimes|string|max:100',
        'nim' => 'sometimes|string|unique:users,nim,' . $user->id,
        'full_name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'phone_number' => 'sometimes|string|max:20',
        'address' => 'sometimes|string|max:255',
        'date_of_birth' => 'sometimes|date',
        'image' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->has('name')) {
        $user->name = $request->name;
    }
    if ($request->has('email')) {
        $user->email = $request->email;
    }
    if ($request->has('phone_number')) {
        $user->phone_number = $request->phone_number;
    }
    if ($request->has('address')) {
        $user->address = $request->address;
    }
    if ($request->has('nim')) {
        $user->nim = $request->nim;
    }
    if ($request->has('full_name')) {
        $user->full_name = $request->full_name;
    }
    if ($request->has('date_of_birth')) {
        $user->date_of_birth = $request->date_of_birth;
    }

    if ($request->hasFile('image')) {
        if ($user->image && Storage::disk('public')->exists(str_replace('storage/', '', $user->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $user->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/users', $filename, 'public');
        $user->image = 'storage/' . $path;
    }

    $user->save();

    return response()->json([
        'message' => 'Profil berhasil diperbarui!',
        'user' => $user
    ]);
}


    /**
     * Upload Profile Image Saja - Jika mau upload gambar doang
     */
    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = $request->user();

        if ($user->image && Storage::disk('public')->exists(str_replace('storage/', '', $user->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $user->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads/users', $filename, 'public');

        $user->image = 'storage/' . $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diupload!',
            'profile_photo_url' => asset($user->image),
            'user' => $user
        ]);
    }

    /**
     * Get Profile Image URL
     */
    public function getProfileImage(Request $request)
    {
        $user = $request->user();

        if (!$user->image) {
            return response()->json([
                'message' => 'Belum ada foto profil',
                'profile_photo_url' => null,
            ], 404);
        }

        return response()->json([
            'message' => 'Berhasil ambil foto profil!',
            'profile_photo_url' => asset($user->image),
        ]);
    }
}