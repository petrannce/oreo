@extends('layouts.backend.header')

@section('content')
    <section class="content blog-page">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Create Medical Report
                        <small>Welcome to Oreo</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Oreo</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('medicals') }}">Medical Records</a></li>
                        <li class="breadcrumb-item active">New Record</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ route('medicals.store') }}" method="POST" id="medicalForm">
                            @csrf
                            <div class="body">

                                {{-- Appointment ID --}}
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? '' }}">

                                {{-- Patient --}}
                                <div class="mb-3">
                                    <label class="form-label">Patient</label>
                                    @if(isset($appointment) && $appointment?->patient)
                                        <input type="text" class="form-control"
                                            value="{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}"
                                            readonly>
                                        <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <small>⚠️ Patient information could not be loaded. Please select from an existing
                                                appointment.</small>
                                        </div>
                                    @endif
                                </div>

                                {{-- Doctor --}}
                                <div class="mb-3">
                                    <label for="doctor" class="form-label">Doctor</label>
                                    <input name="doctor_id" type="hidden" value="{{ auth()->id() }}">
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->fname }} {{ auth()->user()->lname }}" readonly />
                                </div>

                                {{-- Record Date --}}
                                <div class="mb-3">
                                    <label for="record_date" class="form-label">Record Date</label>
                                    <input type="date" class="form-control" name="record_date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}">
                                </div>

                                {{-- Route Type --}}
                                <div class="mb-3">
                                    <label class="form-label">Route Type</label>
                                    <select class="form-control" name="route_type" id="routeType">
                                        <option value="">-- Select Route --</option>
                                        <option value="lab">Send to Lab</option>
                                        <option value="pharmacy">Send to Pharmacy</option>
                                    </select>
                                </div>

                                {{-- Lab Test Section --}}
                                <div id="labSection" class="mb-3" style="display:none;">
                                    <label class="form-label text-warning">Select Lab Tests</label>
                                    <div class="form-check">
                                        @foreach($lab_tests as $labTest)
                                            <label class="form-check-label d-block">
                                                <input type="checkbox" name="lab_tests[]" value="{{ $labTest->id }}">
                                                {{ $labTest->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <p class="text-muted small mt-2">Once submitted, the patient will move to the lab queue.
                                        Diagnosis and prescription will unlock after lab results are filled.</p>
                                </div>

                                {{-- Diagnosis --}}
                                <div id="diagnosisSection" class="mb-3">
                                    <label for="diagnosis" class="form-label">Diagnosis</label>
                                    <textarea rows="3" class="form-control no-resize" name="diagnosis"
                                        placeholder="Type your diagnosis..." required></textarea>
                                </div>

                                {{-- Prescription --}}
                                <div id="prescriptionSection" class="mb-3">
                                    <label for="prescription" class="form-label">Prescription</label>
                                    <textarea rows="3" class="form-control no-resize" name="prescription"
                                        placeholder="Type your prescription..." required></textarea>
                                </div>

                                {{-- Notes --}}
                                <div id="notesSection" class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea rows="3" class="form-control no-resize" name="notes"
                                        placeholder="Additional notes..." required></textarea>
                                </div>
                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                <a href="{{ route('appointments') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Dynamic Form Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const routeType = document.getElementById('routeType');
            const labSection = document.getElementById('labSection');
            const diagnosis = document.getElementById('diagnosisSection');
            const prescription = document.getElementById('prescriptionSection');
            const notes = document.getElementById('notesSection');

            routeType.addEventListener('change', function () {
                if (this.value === 'lab') {
                    labSection.style.display = 'block';
                    [diagnosis, prescription, notes].forEach(section => {
                        section.querySelector('textarea').setAttribute('disabled', 'disabled');
                    });
                } else if (this.value === 'pharmacy') {
                    labSection.style.display = 'none';
                    [diagnosis, prescription, notes].forEach(section => {
                        section.querySelector('textarea').removeAttribute('disabled');
                    });
                } else {
                    labSection.style.display = 'none';
                    [diagnosis, prescription, notes].forEach(section => {
                        section.querySelector('textarea').removeAttribute('disabled');
                    });
                }
            });
        });
    </script>
@endsection