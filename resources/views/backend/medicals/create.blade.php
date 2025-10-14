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

                                {{-- Patient Info + Triage --}}
                                <div class="mb-3">
                                    <label class="form-label">Patient</label>
                                    @if(isset($appointment) && $appointment?->patient)
                                        <input type="text" class="form-control"
                                            value="{{ $appointment->patient->fname }} {{ $appointment->patient->lname }}"
                                            readonly>
                                        <input type="hidden" name="patient_id" value="{{ $appointment->patient->id }}">
                                        {{-- Show triage info --}}
                                        @if($appointment->triage)
                                            <div class="mt-2 card p-2 bg-light">
                                                <p><strong>Temperature:</strong> {{ $appointment->triage->temperature ?? 'N/A' }} °C
                                                </p>
                                                <p><strong>Heart Rate:</strong> {{ $appointment->triage->heart_rate ?? 'N/A' }}</p>
                                                <p><strong>Blood Pressure:</strong>
                                                    {{ $appointment->triage->blood_pressure ?? 'N/A' }}</p>
                                                <p><strong>Weight:</strong> {{ $appointment->triage->weight ?? 'N/A' }} kg</p>
                                                <p><strong>Notes:</strong> {{ $appointment->triage->notes ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <small>⚠️ Patient information could not be loaded.</small>
                                        </div>
                                    @endif
                                </div>

                                {{-- Doctor --}}
                                <div class="mb-3">
                                    <label class="form-label">Doctor</label>
                                    <input type="hidden" name="doctor_id" value="{{ auth()->id() }}">
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->fname }} {{ auth()->user()->lname }}" readonly>
                                </div>

                                {{-- Record Date --}}
                                <div class="mb-3">
                                    <label class="form-label">Record Date</label>
                                    <input type="date" class="form-control" name="record_date" value="{{ date('Y-m-d') }}"
                                        min="{{ date('Y-m-d') }}">
                                </div>

                                {{-- Lab Results --}}
                                @if($appointment->labTest)
                                    <div class="mb-3 card p-3 bg-light">
                                        <h5 class="text-warning">Lab Results</h5>
                                        <p><strong>Test:</strong> {{ $appointment->labTest->test_name }}</p>
                                        <p><strong>Results:</strong> {{ $appointment->labTest->results ?? 'Pending' }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($appointment->labTest->status ?? 'Pending') }}
                                        </p>
                                    </div>
                                @endif

                                {{-- Route Type --}}
                                @php
                                    $disableFields = false;
                                    if ($appointment->process_stage === 'lab' && (!$appointment->labTest || !$appointment->labTest->results_filled)) {
                                        $disableFields = true;
                                    }
                                @endphp

                                <div class="mb-3">
                                    <label class="form-label">Route Type</label>
                                    <select class="form-control" name="route_type" id="routeType" @if($disableFields)
                                    disabled @endif>
                                        <option value="">-- Select Route --</option>
                                        <option value="lab">Send to Lab</option>
                                        <option value="pharmacy">Send to Pharmacy</option>
                                    </select>
                                </div>

                                {{-- Lab Test Selection --}}
                                <div id="labSection" class="mb-3" style="display:none;">
                                    <label class="form-label text-warning">Select Lab Tests</label>
                                    <div class="form-check">
                                        @foreach($lab_tests as $labTest)
                                            <label class="form-check-label d-block">
                                                <input type="checkbox" name="lab_tests[]" value="{{ $labTest->id }}"
                                                    @if($disableFields) disabled @endif>
                                                {{ $labTest->test_name }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <p class="text-muted small mt-2">
                                        Once submitted, patient will move to the lab queue. Diagnosis and prescription
                                        unlock after lab results are filled.
                                    </p>
                                </div>

                                {{-- Diagnosis --}}
                                <div class="mb-3">
                                    <label class="form-label">Diagnosis</label>
                                    <textarea rows="3" class="form-control no-resize" name="diagnosis"
                                        placeholder="Type your diagnosis..." @if($disableFields) disabled
                                        @endif>{{ old('diagnosis') }}</textarea>
                                </div>

                                {{-- Prescription --}}
                                <div class="mb-3">
                                    <label class="form-label">Prescription</label>
                                    <textarea rows="3" class="form-control no-resize" name="prescription"
                                        placeholder="Type your prescription..." @if($disableFields) disabled
                                        @endif>{{ old('prescription') }}</textarea>
                                </div>

                                {{-- Notes --}}
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea rows="3" class="form-control no-resize" name="notes"
                                        placeholder="Additional notes..." @if($disableFields) disabled
                                        @endif>{{ old('notes') }}</textarea>
                                </div>

                            </div>

                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary btn-round" @if($disableFields) disabled
                                @endif>Submit</button>
                                <a href="{{ route('appointments') }}"
                                    class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const routeType = document.getElementById('routeType');
            const formFields = document.querySelectorAll('#medicalForm textarea, #medicalForm input, #medicalForm select, #medicalForm button[type=submit]');
            const labSection = document.getElementById('labSection');

            // Enable fields if lab results already filled
            const labResultsFilled = {{ $appointment->labTest && $appointment->labTest->results_filled ? 'true' : 'false' }};
            if (labResultsFilled) {
                formFields.forEach(el => el.disabled = false);
            }

            // Poll lab status every 5 seconds if in lab stage and results not yet filled
            let labPoll;
            @if($appointment->process_stage === 'lab' && (!$appointment->labTest || !$appointment->labTest->results_filled))
                labPoll = setInterval(() => {
                    fetch("{{ url('admin/appointments/' . $appointment->id . '/lab-status') }}", {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.results_filled) {
                                formFields.forEach(el => el.disabled = false);
                                clearInterval(labPoll);
                                location.reload(); // show lab results dynamically
                            }
                        })
                        .catch(err => console.error('Lab status check failed', err));
                }, 5000);
            @endif

            // Handle route selection
            routeType?.addEventListener('change', function () {
                const route = this.value;
                if (route === 'lab' || route === 'pharmacy') {
                    // disable all form fields
                    formFields.forEach(el => el.disabled = true);

                    // show lab section if lab
                    if (route === 'lab') labSection.style.display = 'block';

                    let stage = route === 'lab' ? 'lab' : 'pharmacy';
                    fetch(`{{ url('admin/appointments/update-stage/' . $appointment->id) }}/${stage}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert(data.message);
                                window.location.href = "{{ route('appointments') }}";
                            } else {
                                alert(data.message || 'Error moving stage.');
                                formFields.forEach(el => el.disabled = false);
                            }
                        })
                        .catch(err => {
                            console.error('Stage update failed', err);
                            formFields.forEach(el => el.disabled = false);
                        });
                }
            });

            // Show lab section if already selected
            if (routeType?.value === 'lab') labSection.style.display = 'block';
        });
    </script>

@endsection