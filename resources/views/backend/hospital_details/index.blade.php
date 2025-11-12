@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="font-weight-bold mb-0">Hospital Details</h2>
                <small class="text-muted">Update the official hospital information</small>
            </div>
            <div class="col-md-4 text-md-right">
                <a href="{{ route('admin') }}" class="btn btn-outline-primary btn-round">
                    <i class="zmdi zmdi-home"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @php
            $hospital = $hospital_details->first() ?? new \App\Models\HospitalDetail;
        @endphp

        <div class="row clearfix">

            {{-- LEFT SIDEBAR: LOGO + BANNER --}}
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="body text-center p-4">

                        {{-- LOGO --}}
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $hospital->logo ? asset($hospital->logo) : asset('assets/images/default_logo.png') }}"
                                 alt="Logo"
                                 class="rounded shadow-sm"
                                 style="width:150px; height:150px; object-fit:cover;">

                            <form action="{{ $hospital->id ? route('hospital_details.update', $hospital->id) : '#' }}" 
                                  method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                @if($hospital->id) @method('PUT') @endif
                                <input type="hidden" name="inline" value="logo">
                                <label for="logoInput" class="btn btn-light btn-round mt-2">
                                    <i class="zmdi zmdi-upload"></i> Change Logo
                                </label>
                                <input type="file" name="logo" id="logoInput" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>

                        {{-- BANNER --}}
                        <div class="position-relative mt-3">
                            <img src="{{ $hospital->image ? asset($hospital->image) : asset('assets/images/default_banner.jpg') }}"
                                 alt="Banner"
                                 class="rounded shadow-sm"
                                 style="width:100%; height:180px; object-fit:cover;">

                            <form action="{{ $hospital->id ? route('hospital_details.update', $hospital->id) : '#' }}" 
                                  method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                @if($hospital->id) @method('PUT') @endif
                                <input type="hidden" name="inline" value="image">
                                <label for="bannerInput" class="btn btn-light btn-round mt-2">
                                    <i class="zmdi zmdi-image"></i> Change Banner
                                </label>
                                <input type="file" name="image" id="bannerInput" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>

                        <hr>
                        <p class="small text-muted mt-2">
                            Last Updated: {{ $hospital->updated_at ? $hospital->updated_at->diffForHumans() : 'Never' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- RIGHT MAIN CONTENT: HOSPITAL DETAILS FORM --}}
            <div class="col-lg-8 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="body p-4">
                        <form action="{{ $hospital->id ? route('hospital_details.update', $hospital->id) : route('hospital_details.store') }}" 
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($hospital->id) @method('PUT') @endif
                            <input type="hidden" name="inline" value="">

                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <label>Hospital Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $hospital->name) }}">
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <textarea name="address" class="form-control" rows="3">{{ old('address', $hospital->address) }}</textarea>
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $hospital->phone_number) }}">
                                    @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $hospital->email) }}">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Website</label>
                                    <input type="text" name="website" class="form-control" value="{{ old('website', $hospital->website) }}">
                                    @error('website') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                            </div>

                            <div class="text-right mt-3">
                                <button class="btn btn-primary btn-round">
                                    <i class="zmdi zmdi-save"></i> {{ $hospital->id ? 'Save Changes' : 'Add Hospital' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
