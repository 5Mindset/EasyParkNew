@extends('layouts.app')



@section('content')

<div class="container py-5">

    <div class="mb-2">

        <h3 class="fw-bold">Edit Mahasiswa</h3>

        <p class="text-muted small mb-0">

            <a href="{{ route('students.index') }}" class="text-decoration-none text-muted">Mahasiswa</a>

            <span class="mx-1">/</span>

            <span class="text-primary fw-semibold">Edit</span>

        </p>

    </div>



    <div class="card border-0 shadow rounded-4 mt-3">

        <div class="card-body p-4">

            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">

                @csrf

                @method('PUT')

                <div class="row">

                    <div class="col-md-6">

                        {{-- NIM --}}

                        <div class="mb-3">

                            <label for="nim" class="form-label">NIM</label>

                            <input type="text" name="nim" id="nim"

                                class="form-control @error('nim') is-invalid @enderror"

                                value="{{ old('nim', $student->nim) }}" placeholder="Nomor Induk Mahasiswa" required>

                            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>



                        {{-- Email --}}

                        <div class="mb-3">

                            <label for="email" class="form-label">Email</label>

                            <input type="email" name="email" id="email"

                                class="form-control @error('email') is-invalid @enderror"

                                value="{{ old('email', $student->email) }}" placeholder="Email aktif" required>

                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>



                        {{-- Tanggal Lahir --}}

                        <div class="mb-3">

                            <label for="date_of_birth" class="form-label">Tanggal Lahir</label>

                            <input type="date" name="date_of_birth" id="date_of_birth"

                                class="form-control @error('date_of_birth') is-invalid @enderror"

                                value="{{ old('date_of_birth', $student->date_of_birth) }}">

                            @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>



                        {{-- Foto --}}

                        <div class="mb-3">

                            <label for="image" class="form-label">Foto</label>

                            <input type="file" name="image" id="image"

                                class="form-control @error('image') is-invalid @enderror"

                                accept="image/*">

                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>

                    </div>



                    <div class="col-md-6">

                        {{-- Nama Lengkap --}}

                        <div class="mb-3">

                            <label for="full_name" class="form-label">Nama Lengkap</label>

                            <input type="text" name="full_name" id="full_name"

                                class="form-control @error('full_name') is-invalid @enderror"

                                value="{{ old('full_name', $student->full_name) }}" placeholder="Nama lengkap" required>

                            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>



                        {{-- Nomor HP --}}

                        <div class="mb-3">

                            <label for="phone_number" class="form-label">Nomor HP</label>

                            <input type="text" name="phone_number" id="phone_number"

                                class="form-control @error('phone_number') is-invalid @enderror"

                                value="{{ old('phone_number', $student->phone_number) }}" placeholder="08xxxxxxxxxx">

                            @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>



                        {{-- Alamat --}}

                        <div class="mb-3">

                            <label for="address" class="form-label">Alamat</label>

                            <textarea name="address" id="address" rows="5"

                                class="form-control @error('address') is-invalid @enderror"

                                placeholder="Alamat lengkap">{{ old('address', $student->address) }}</textarea>

                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        </div>

                    </div>

                </div>



                <div class="mt-4">

                    <button type="submit" class="btn btn-primary">

                        <i class="bi bi-save"></i> Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

