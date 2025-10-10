@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>View Lab Test <small>Welcome to Hospital System</small></h2>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
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
                                        <input type="text" class="form-control"
                                            value="{{ $lab_test->lab_technician->fname }} {{ $lab_test->lab_technician->lname }}" readonly>
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
                                        <input type="text" class="form-control"
                                            value="#{{ $lab_test->appointment->id }} - {{ $lab_test->appointment->date }}" readonly>
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
                                        <input type="text" name="status" class="form-control" value="{{ $lab_test->status }}" required>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('appointments') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
