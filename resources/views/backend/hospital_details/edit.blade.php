@extends('layouts.backend.header')

@section('content')
@php
    // Defensive: If no hospital record, create a temporary object
    if (!isset($hospital_detail)) {
        $hospital_detail = new \App\Models\HospitalDetail;
    }
@endphp

<section class="content profile-page">
    <div class="block-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="font-weight-bold mb-0">{{ $hospital_detail->id ? 'Edit Hospital' : 'Add Hospital' }}</h2>
                <small class="text-muted">Manage hospital details, logo, and images</small>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <a href="{{ route('hospital_details.index') }}" class="btn btn-outline-primary btn-round">
                    <i class="zmdi zmdi-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="body text-center p-4">
                        {{-- Logo --}}
                        <div class="position-relative d-inline-block">
                            <img src="{{ $hospital_detail->logo ? asset('storage/'.$hospital_detail->logo) : asset('assets/images/hospital_logo_placeholder.png') }}"
                                 alt="Hospital Logo"
                                 class="rounded-circle img-fluid shadow-sm mb-3"
                                 style="width:130px; height:130px; object-fit:cover;">

                            <form action="{{ route('hospital_details.update', $hospital_detail->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="inline" value="logo">
                                <label for="logo_input" class="btn btn-sm btn-light btn-round mt-2">
                                    <i class="zmdi zmdi-camera"></i> Change Logo
                                </label>
                                <input type="file" name="logo" id="logo_input" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>

                        {{-- Banner Image --}}
                        <div class="position-relative d-inline-block mt-3">
                            <img src="{{ $hospital_detail->image ? asset('storage/'.$hospital_detail->image) : asset('assets/images/hospital_image_placeholder.png') }}"
                                 alt="Hospital Banner"
                                 class="rounded shadow-sm img-fluid mb-2"
                                 style="width:100%; height:150px; object-fit:cover;">

                            <form action="{{ route('hospital_details.update', $hospital_detail->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="inline" value="image">
                                <label for="image_input" class="btn btn-sm btn-light btn-round mt-2">
                                    <i class="zmdi zmdi-camera"></i> Change Banner
                                </label>
                                <input type="file" name="image" id="image_input" class="d-none" onchange="this.form.submit()">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-lg-8 col-md-12">
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="body p-4">
                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Success / Error Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        {{-- Hospital Details Form --}}
                        <form action="{{ route('hospital_details.update', $hospital_detail->id ?? 0) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Hospital Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $hospital_detail->name }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $hospital_detail->address }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ $hospital_detail->phone_number }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $hospital_detail->email }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label>Website</label>
                                    <input type="text" name="website" class="form-control" value="{{ $hospital_detail->website }}">
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary btn-round"><i class="zmdi zmdi-save"></i> Save Changes</button>
                                <a href="{{ route('hospital_details.index') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Optional: Recent Activity / Logs --}}
                {{-- You can add a small panel here showing last updates, logo changes etc --}}
            </div>
        </div>
    </div>
</section>
@endsection
