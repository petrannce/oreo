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

                    <form action="{{ route('lab_tests.update', $lab_test->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="body">
                            <div class="row clearfix">
                                {{-- Patient --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <input type="hidden" name="patient_id" value="{{ $lab_test->patient_id }}">
                                        <input type="text" class="form-control"
                                            value="{{ optional($lab_test->patient)->fname }} {{ optional($lab_test->patient)->lname }}" readonly>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <input type="hidden" name="doctor_id" value="{{ $lab_test->doctor_id }}">
                                        <input type="text" class="form-control"
                                            value="{{ optional($lab_test->doctor)->fname }} {{ optional($lab_test->doctor)->lname }}" readonly>
                                    </div>
                                </div>

                                {{-- Lab Technician --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Lab Technician</label>
                                        <input type="hidden" name="lab_technician_id" value="{{ $lab_test->lab_technician_id }}">
                                        <input type="text" class="form-control"
                                            value="{{ optional($lab_test->labTechnician)->fname }} {{ optional($lab_test->labTechnician)->lname }}" readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Test Names --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Test Name(s)</label>
                                        <input type="hidden" name="test_name" value="{{ $lab_test->test_name }}">
                                        @php
                                            $testNames = array_map('trim', explode(',', $lab_test->test_name));
                                        @endphp
                                        @foreach($testNames as $test)
                                            <p class="form-control-static">• {{ $test }}</p>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Appointment --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Appointment</label>
                                        <input type="hidden" name="appointment_id" value="{{ $lab_test->appointment_id }}">
                                        <input type="text" class="form-control"
                                            value="#{{ optional($lab_test->appointment)->id }} - {{ optional($lab_test->appointment)->date }}" readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Results --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Results (Enter each test result on a new line)</label>
                                        <textarea name="results" class="form-control" rows="4"
                                            placeholder="e.g. Blood Test - Normal&#10;Urine Test - Clear">{{ old('results', $lab_test->results) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="requested" {{ $lab_test->status == 'requested' ? 'selected' : '' }}>Requested</option>
                                            <option value="in_progress" {{ $lab_test->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="completed" {{ $lab_test->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="zmdi zmdi-save"></i> Save Changes
                                </button>
                                <a href="{{ route('appointments') }}" class="btn btn-default btn-round btn-simple">
                                    <i class="zmdi zmdi-close"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
