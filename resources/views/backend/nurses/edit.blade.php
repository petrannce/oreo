@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Edit Doctor
                        <small>Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                        <li class="breadcrumb-item"><a href="{{route('doctors')}}">Doctor</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Edit</strong> Doctor </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form action="{{route('doctors.update', $doctor->id)}}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Full Name" class="form-label">Full Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $doctor->user->fname }} {{ $doctor->user->lname }}"
                                                readonly>

                                            <input type="hidden" name="user_id" class="form-control"
                                                value="{{ $doctor->user->id }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Employee Type" class="form-label">Employee Type</label>
                                        <select class="form-control show-tick" name="employment_type" required>
                                            <option value="" disabled {{ $doctor->department ? '' : 'selected' }}>- Employee Type -</option>
                                            <option value="permanent">Permanent</option>
                                            <option value="contract">Contract</option>
                                            <option value="volunteer">Volunteer</option>
                                            <option value="consultant">Consultant</option>
                                            <option value="other">Other</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">

                                <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="Full Name" class="form-label">Department</label>
                                            <select class="form-control show-tick" name="department" id="department">
                                                <option value="" disabled {{ $doctor->department ? '' : 'selected' }}>Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->name}} {{ $doctor->department === $department->name ? 'selected' : '' }}">{{$department->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="Speciality" class="form-label">Speciality</label>
                                            <input type="text" name="speciality" class="form-control"
                                                value="{{ $doctor->speciality }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="License Number" class="form-label">License Number <small>(Start with LN...)</small></label>
                                            <input type="text" name="license_number" class="form-control"
                                                value="{{ $doctor->license_number }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="Bio" class="form-label">Bio</label>
                                            <textarea rows="4" name="bio" class="form-control no-resize"
                                                placeholder="Please type what you want...">{{ $doctor->bio }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                        <button type="submit" class="btn btn-default btn-round btn-simple">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection