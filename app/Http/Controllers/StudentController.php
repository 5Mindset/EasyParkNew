<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $students = User::where('role', 'mahasiswa')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone_number', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'           => 'required|string|size:9|unique:users,nim',
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:255',
            'password'      => 'required|string|min:6|confirmed',
            'image'         => 'nullable|image|max:2048',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/mahasiswa', 'public');
            }

            User::create([
                'nim'           => $request->nim,
                'name'          => explode(' ', $request->full_name)[0],
                'full_name'     => $request->full_name,
                'email'         => $request->email,
                'phone_number'  => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'address'       => $request->address,
                'password'      => Hash::make($request->password),
                'role'          => 'mahasiswa',
                'image'         => $imagePath,
            ]);

            return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
        } catch (QueryException $e) {
            Log::error('Student store failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Gagal menambahkan mahasiswa. Periksa input Anda.');
        }
    }

    public function edit(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        return view('admin.students.edit', compact('student'));
    }

    public function show(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        return view('admin.students.show', compact('student'));
    }

    public function update(Request $request, User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $request->validate([
            'nim'           => 'required|string|size:9|unique:users,nim,' . $student->id,
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $student->id,
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:255',
            'password'      => 'nullable|string|min:6|confirmed',
            'image'         => 'nullable|image|max:2048',
        ]);

        try {
            $data = $request->only([
                'full_name',
                'email',
                'phone_number',
                'date_of_birth',
                'address',
            ]);

            $data['nim'] = $request->nim;
            $data['name'] = explode(' ', $request->full_name)[0];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                if ($student->image) {
                    Storage::disk('public')->delete($student->image);
                }
                $data['image'] = $request->file('image')->store('uploads/mahasiswa', 'public');
            }

            $student->update($data);

            return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
        } catch (QueryException $e) {
            Log::error('Student update failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Gagal memperbarui data mahasiswa. Periksa input Anda.');
        }
    }

    public function destroy(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        try {
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            $student->delete();

            return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil dihapus.');
        } catch (QueryException $e) {
            Log::error('Student delete failed: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus mahasiswa. Data mungkin sedang digunakan.');
        }
    }
}
