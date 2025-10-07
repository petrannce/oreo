@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Add Nurse
                        <small>Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.nurses') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('nurses') }}">Nurses</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Nurse </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <form action="{{ route('nurses.store') }}" method="POST">
                                @csrf

                                <div class="row clearfix">

                                    {{-- Select User --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="user_id" class="form-label">Select User</label>
                                            <select class="form-control show-tick" name="user_id" id="user_id" required>
                                                <option value="" selected disabled>-- Select User --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->fname }} {{ $user->lname }} - {{ $user->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Department --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="department" class="form-label">Department</label>
                                            <select class="form-control show-tick" name="department" id="department"
                                                required>
                                                <option value="" selected disabled>-- Select Department --</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->name }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Employment Type --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="employment_type" class="form-label">Employment Type</label>
                                            <select class="form-control show-tick" name="employment_type" required>
                                                <option value="">-- Select Type --</option>
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

                                    {{-- License --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="license_number" class="form-label">Nursing License Number</label>
                                            <input type="text" name="license_number" class="form-control"
                                                placeholder="e.g. NRN12345" required>
                                        </div>
                                    </div>


                                    {{-- Employee Code --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="speciality" class="form-label">Employee Code</label>
                                            <input type="text" name="employee_code" class="form-control"
                                                placeholder="Employee Code" required>
                                        </div>
                                    </div>

                                    {{-- Hire Date --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="hire_date" class="form-label">Hire Date</label>
                                            <input type="date" name="hire_date" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Bio --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="bio" class="form-label">Bio</label>
                                        <textarea rows="4" name="bio" class="form-control no-resize"
                                            placeholder="Brief background, training, experience..."></textarea>
                                    </div>
                                </div>


                                {{-- Submit --}}
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <a href="{{ route('nurses') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                </div>

                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection