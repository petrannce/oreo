@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Edit Lab Test <small>Welcome to Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <form action="{{ route('lab_tests.update', $lab_test->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row clearfix">

                                {{-- Patient --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <input type="text" class="form-control"
                                            value="{{ $lab_test->patient->fname }} {{ $lab_test->patient->lname }}" readonly>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <input type="text" class="form-control"
                                            value="{{ $lab_test->doctor->fname }} {{ $lab_test->doctor->lname }}" readonly>
                                    </div>
                                </div>

                                {{-- Lab Technician --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Lab Technician</label>
                                        <select name="lab_technician_id" class="form-control show-tick">
                                            <option value="">-- Assign Later --</option>
                                            @foreach($technicians as $tech)
                                                <option value="{{ $tech->id }}" {{ $lab_test->lab_technician_id == $tech->id ? 'selected' : '' }}>
                                                    {{ $tech->fname }} {{ $tech->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Test Name --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Test Name</label>
                                        <input type="text" name="test_name" class="form-control" value="{{ $lab_test->test_name }}" required>
                                    </div>
                                </div>

                                {{-- Appointment --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Appointment</label>
                                        <select name="appointment_id" class="form-control show-tick">
                                            <option value="">-- None --</option>
                                            @foreach($appointments as $appt)
                                                <option value="{{ $appt->id }}" {{ $lab_test->appointment_id == $appt->id ? 'selected' : '' }}>
                                                    #{{ $appt->id }} - {{ $appt->date }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Results --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Results</label>
                                        <textarea name="results" class="form-control" rows="4">{{ $lab_test->results }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control show-tick">
                                            <option value="requested" {{ $lab_test->status == 'requested' ? 'selected' : '' }}>Requested</option>
                                            <option value="in_progress" {{ $lab_test->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $lab_test->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-round">Update</button>
                            <a href="{{ route('lab_tests.index') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
