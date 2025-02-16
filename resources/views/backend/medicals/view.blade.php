@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>View Medical Record
                        <small class="text-muted">Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Oreo</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('medicals') }}">Medical</a></li>
                        <li class="breadcrumb-item active">View medical record</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>View</strong> Information <small>medical details...</small> </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="fname">Full Names</label>
                                        <input type="text" class="form-control"
                                            value="{{ $appointment->patient->fname ?? '' }} {{ $appointment->patient->lname ?? '' }}" placeholder="First Name" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="text" class="form-control" value="{{ $appointment->patient->phone_number ?? '' }}"
                                            placeholder="Phone No." readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="doctor">Doctor</label>
                                        <input type="text" class="form-control" value="{{ $appointment->doctor->fname ?? '' }} {{ $appointment->doctor->lname ?? '' }}"
                                            placeholder="Enter Your Doctor" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Medical</strong> records <small>Medical details of the patient...</small> </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="patient_id">Patient ID</label>
                                            <input type="text" class="form-control" name="patient_id"
                                                value="{{ $appointment->id }}" placeholder="Patient ID" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="record_date">Record Date</label>
                                            <input type="date" class="form-control" name="record_date" value="{{ $medical_record->record_date }}"
                                                placeholder="Record Date" min="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="diagnosis">Diagnosis</label>
                                            <textarea rows="4" class="form-control no-resize" name="diagnosis"
                                                placeholder="Diagnosis" readonly>{{ $medical_record->diagnosis }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="prescription">Prescription</label>
                                            <textarea rows="4" class="form-control no-resize" name="prescription"
                                                placeholder="Prescription" readonly>{{ $medical_record->prescription }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea rows="4" class="form-control no-resize" name="notes"
                                                placeholder="Notes" readonly>{{ $medical_record->notes }}</textarea>
                                        </div>
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