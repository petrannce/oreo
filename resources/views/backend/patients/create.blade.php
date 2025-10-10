@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Create Patient
                    <small>Manage patient details</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients') }}">Patients</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Create</strong> Patient Details</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf

                            {{-- Patient Basic Info --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname" class="form-label">First Name</label>
                                        <input type="text" name="fname" class="form-control" aria-controls=""required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lname" class="form-label">Last Name</label>
                                        <input type="text" name="lname" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Contact Info --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- Gender / DOB --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select name="gender" class="form-control show-tick">
                                            <option value="" disabled>-- Select Gender --</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control"
                                               max="{{ \Carbon\Carbon::today()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- Emergency Contact --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                                        <input type="text" name="emergency_contact_name" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                                        <input type="text" name="emergency_contact_phone" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="relationship_to_patient" class="form-label">Relationship</label>
                                        <input type="text" name="relationship_to_patient" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- MRN (Locked) --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="medical_record_number" class="form-label">Medical Record Number</label>
                                        <input type="text" name="medical_record_number" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Create Patient</button>
                                    <a href="{{ route('patients') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
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
