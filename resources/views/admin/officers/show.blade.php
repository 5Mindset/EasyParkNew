@extends('layouts.app')



@section('content')

    <div class="container py-5">

        {{-- Tombol Kembali --}}

        <div class="mb-2">

        <h3 class="fw-bold">Edit Petugas</h3>

        <p class="text-muted small mb-0">

            <a href="{{ route('officers.index') }}" class="text-decoration-none text-muted">Petugas</a>

            <span class="mx-1">/</span>

            <span class="text-primary fw-semibold">Show</span>

        </p>

    </div>



        {{-- Card Detail Petugas --}}

        <div class="card border-0 shadow rounded-4">

            <div class="card-body p-4">

                <div class="row g-4 align-items-center">

                    {{-- Foto Petugas --}}

                    <div class="col-md-3 text-center">

                        <div style="width: 150px; height: 150px; margin: 0 auto;">

                            @if ($officer->image)

                                <img src="{{ asset('storage/' . $officer->image) }}" alt="Foto Petugas"

                                    class="rounded-circle w-100 h-100 object-fit-cover">

                            @else

                                <div

                                    class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle w-100 h-100">

                                    <i class="bi bi-person-fill fs-1"></i>

                                </div>

                            @endif

                        </div>

                    </div>



                    {{-- Detail Informasi --}}

                    <div class="col-md-9">

                        <h4 class="fw-bold mb-3">{{ $officer->full_name }}</h4>



                        <div class="row">

                            <div class="col-md-6 mb-2">

                                <strong>NIP:</strong><br>

                                {{ $officer->nip ?? '-' }}

                            </div>

                            <div class="col-md-6 mb-2">

                                <strong>Email:</strong><br>

                                {{ $officer->email }}

                            </div>

                            <div class="col-md-6 mb-2">

                                <strong>No. HP:</strong><br>

                                {{ $officer->phone_number ?? '-' }}

                            </div>

                            <div class="col-md-6 mb-2">

                                <strong>Tanggal Lahir:</strong><br>

                                {{ $officer->date_of_birth ? \Carbon\Carbon::parse($officer->date_of_birth)->translatedFormat('d M Y') : '-' }}

                            </div>

                            <div class="col-md-12 mb-2">

                                <strong>Alamat:</strong><br>

                                {{ $officer->address ?? '-' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



@endsection

