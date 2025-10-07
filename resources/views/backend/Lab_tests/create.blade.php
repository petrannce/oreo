@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Create Lab Test <small>Welcome to Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form action="{{ route('lab_tests.store') }}" method="POST">
                            @csrf
                            <div class="row clearfix">

                                {{-- Patient --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <select name="patient_id" class="form-control show-tick" required>
                                            <option value="">-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">{{ $patient->fname }} {{ $patient->lname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select name="doctor_id" class="form-control show-tick" required>
                                            <option value="">-- Select Doctor --</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->fname }} {{ $doctor->lname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Lab Technician --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Lab Technician</label>
                                        <select name="lab_technician_id" class="form-control show-tick">
                                            <option value="">-- Assign Later --</option>
                                            @foreach($lab_technicians as $tech)
                                                <option value="{{ $tech->id }}">{{ $tech->fname }} {{ $tech->lname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Appointment --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Appointment</label>
                                        <select name="appointment_id" class="form-control show-tick">
                                            <option value="">-- None --</option>
                                            @foreach($appointments as $appt)
                                                <option value="{{ $appt->id }}">#{{ $appt->id }} - {{ $appt->date }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Test Name --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Test Name</label>
                                        <input type="text" name="test_name" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Results --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Results</label>
                                        <textarea name="results" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control show-tick">
                                            <option value="requested">Requested</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round">Create</button>
                            <a href="{{ route('lab_tests') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
