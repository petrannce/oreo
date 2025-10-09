@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Create Triage
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('triages') }}">Triages</a></li>
                    <li class="breadcrumb-item active">Create Triage</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add New</strong> Triage</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('triages.store') }}" method="POST">
                            @csrf

                            {{-- Hidden Fields --}}
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                            <input type="hidden" name="nurse_id" value="{{ $loggedInNurseId }}">

                            {{-- Read-Only Appointment Info --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Patient</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Appointment Date</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $appointment->date }}" readonly>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Doctor</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $appointment->doctor->fname }} {{ $appointment->doctor->lname }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Service</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $appointment->service->name }}" readonly>
                                </div>
                            </div>

                            <hr>

                            {{-- Triage Vitals --}}
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label for="temperature">Temperature (°C)</label>
                                    <input type="number" step="0.01" name="temperature" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="heart_rate">Heart Rate (bpm)</label>
                                    <input type="text" name="heart_rate" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="blood_pressure">Blood Pressure (mmHg)</label>
                                    <input type="text" name="blood_pressure" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="weight">Weight (kg)</label>
                                    <input type="number" step="0.01" name="weight" class="form-control">
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="form-group mt-3">
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                            </div>

                            {{-- Buttons --}}
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="zmdi zmdi-save"></i> Save Triage
                                </button>
                                <a href="{{ route('triages') }}" class="btn btn-secondary">
                                    <i class="zmdi zmdi-arrow-left"></i> Cancel
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
