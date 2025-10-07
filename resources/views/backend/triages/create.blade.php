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
                    <li class="breadcrumb-item">
                        <a href="{{ route('triages') }}">Triages</a>
                    </li>
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

                            {{-- Pre-filled Patient --}}
                            <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">

                            {{-- Pre-filled Appointment --}}
                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                            {{-- Hidden Nurse ID (logged in) --}}
                            <input type="hidden" name="nurse_id" id="nurse_id" value="{{ $loggedInNurseId }}">

                            {{-- Vitals & Notes --}}
                            <div class="form-group">
                                <label for="temperature">Temperature (°C)</label>
                                <input type="number" step="0.01" name="temperature" id="temperature" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="heart_rate">Heart Rate (bpm)</label>
                                <input type="text" name="heart_rate" id="heart_rate" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="blood_pressure">Blood Pressure (mmHg)</label>
                                <input type="text" name="blood_pressure" id="blood_pressure" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="weight">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" id="weight" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea name="notes" id="notes" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Triage</button>
                            <a href="{{ route('triages') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
