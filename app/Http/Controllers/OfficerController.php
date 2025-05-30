<?php



namespace App\Http\Controllers;



use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Log;



class OfficerController extends Controller

{

    public function index(Request $request)

    {

        $search = $request->query('search');



        $officers = User::where('role', 'petugas')

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('full_name', 'like', '%' . $search . '%')

                      ->orWhere('email', 'like', '%' . $search . '%')

                      ->orWhere('phone_number', 'like', '%' . $search . '%');

                });

            })

            ->orderBy('created_at', 'desc')

            ->paginate(10);



        return view('admin.officers.index', compact('officers'));

    }



    public function create()

    {

        return view('admin.officers.create');

    }



    public function store(Request $request)

    {

        $request->validate([

            'nip'           => 'required|string|size:18|unique:users,nim',

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

                $imagePath = $request->file('image')->store('uploads/petugas', 'public');

            }



            User::create([

                'nim'           => $request->nip,

                'name'          => explode(' ', $request->full_name)[0],

                'full_name'     => $request->full_name,

                'email'         => $request->email,

                'phone_number'  => $request->phone_number,

                'date_of_birth' => $request->date_of_birth,

                'address'       => $request->address,

                'password'      => Hash::make($request->password),

                'role'          => 'petugas',

                'image'         => $imagePath,

            ]);



            return redirect()->route('officers.index')

                ->with('success', 'Petugas berhasil ditambahkan.');

        } catch (QueryException $e) {

            Log::error('Officer store failed: ' . $e->getMessage());



            return back()

                ->withInput()

                ->with('error', 'Gagal menambahkan petugas. Periksa input Anda.');

        }

    }



    public function edit(User $officer)

    {

        if ($officer->role !== 'petugas') {

            abort(404);

        }



        return view('admin.officers.edit', compact('officer'));

    }



    public function show(User $officer)

    {

        if ($officer->role !== 'petugas') {

            abort(404);

        }



        return view('admin.officers.show', compact('officer'));

    }



    public function update(Request $request, User $officer)

    {

        if ($officer->role !== 'petugas') {

            abort(404);

        }



        $request->validate([

            'nip'           => 'required|string|size:18|unique:users,nim,' . $officer->id,

            'full_name'     => 'required|string|max:255',

            'email'         => 'required|email|unique:users,email,' . $officer->id,

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



            $data['nim'] = $request->nip;

            $data['name'] = explode(' ', $request->full_name)[0];



            if ($request->filled('password')) {

                $data['password'] = Hash::make($request->password);

            }



            if ($request->hasFile('image')) {

                if ($officer->image) {

                    Storage::disk('public')->delete($officer->image);

                }



                $data['image'] = $request->file('image')->store('uploads/petugas', 'public');

            }



            $officer->update($data);



            return redirect()->route('officers.index')

                ->with('success', 'Data petugas berhasil diperbarui.');

        } catch (QueryException $e) {

            Log::error('Officer update failed: ' . $e->getMessage());



            return back()

                ->withInput()

                ->with('error', 'Gagal memperbarui data petugas. Periksa input Anda.');

        }

    }



    public function destroy(User $officer)

    {

        if ($officer->role !== 'petugas') {

            abort(404);

        }



        try {

            if ($officer->image) {

                Storage::disk('public')->delete($officer->image);

            }



            $officer->delete();



            return redirect()->route('officers.index')

                ->with('success', 'Petugas berhasil dihapus.');

        } catch (QueryException $e) {

            Log::error('Officer delete failed: ' . $e->getMessage());



            return back()

                ->with('error', 'Gagal menghapus petugas. Data mungkin sedang digunakan.');

        }

    }

}

