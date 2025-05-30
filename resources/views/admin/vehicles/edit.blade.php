@extends('layouts.app')



@section('content')

    <div class="container py-5">

        <div class="mb-2">

            <h3 class="fw-bold">Edit Kendaraan</h3>

            <p class="text-muted small mb-0">

                <a href="{{ route('vehicles.index') }}" class="text-decoration-none text-muted">

                    Kendaraan

                </a>

                <span class="mx-1">/</span>

                <span class="text-primary fw-semibold">Edit</span>

            </p>

        </div>



        <div class="card border-0 shadow rounded-4 mt-3">

            <div class="card-body p-4">



                {{-- Form Edit Kendaraan --}}

                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')



                    <div class="container mt-3 mb-3">

                        <div class="row row-cols-1 row-cols-md-3 g-4 mb-3">

                            <!-- Tipe Kendaraan -->

                            <div class="col">

                                <label for="vehicle_type_id" class="form-label">Tipe Kendaraan</label>

                                <select name="vehicle_type_id" id="vehicle_type_id" class="form-select">

                                    @foreach ($types as $type)

                                        <option value="{{ $type->id }}"

                                            {{ old('vehicle_type_id', $vehicle->model->vehicle_type_id ?? '') == $type->id ? 'selected' : '' }}>

                                            {{ $type->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <!-- Merek Kendaraan -->

                            <div class="col">

                                <label for="vehicle_brand_id" class="form-label">Merek Kendaraan</label>

                                <select name="vehicle_brand_id" id="vehicle_brand_id" class="form-select">

                                    @foreach ($brands as $brand)

                                        <option value="{{ $brand->id }}"

                                            {{ old('vehicle_brand_id', $vehicle->model->vehicle_brand_id ?? '') == $brand->id ? 'selected' : '' }}>

                                            {{ $brand->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <!-- Model Kendaraan -->

                            <div class="col">

                                <label for="vehicle_model_id" class="form-label">Model Kendaraan</label>

                                <select name="vehicle_model_id" id="vehicle_model_id" class="form-select">

                                    @foreach ($models as $model)

                                        <option value="{{ $model->id }}"

                                            {{ old('vehicle_model_id', $vehicle->vehicle_model_id ?? '') == $model->id ? 'selected' : '' }}>

                                            {{ $model->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>



                        <!-- Pemilik Kendaraan -->

                        <div class="mb-3">

                            <label for="user_id" class="form-label">Pemilik Kendaraan (Mahasiswa)</label>

                            <select name="user_id" id="user_id" class="form-select">

                                @foreach ($users as $user)

                                    <option value="{{ $user->id }}"

                                        {{ old('user_id', $vehicle->user_id) == $user->id ? 'selected' : '' }}>

                                        {{ $user->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>



                        <!-- Nomor Plat -->

                        <div class="mb-3">

                            <label for="plate_number" class="form-label">Nomor Plat</label>

                            <input type="text" name="plate_number" id="plate_number"

                                value="{{ old('plate_number', $vehicle->plate_number) }}" class="form-control">

                        </div>



                        <!-- STNK Image -->

                        <div class="mb-4">

                            <label for="stnk_image" class="form-label">STNK Image</label>

                            <input type="file" name="stnk_image" id="stnk_image" class="form-control mb-3">



                            @if ($vehicle->stnk_image)

                                <div>

                                    <img src="{{ asset('storage/' . $vehicle->stnk_image) }}" alt="STNK Image"

                                        style="max-width: 300px; height: auto;" class="img-thumbnail">

                                </div>

                            @endif

                        </div>



                        <button type="submit" class="btn btn-primary">Update Kendaraan</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

