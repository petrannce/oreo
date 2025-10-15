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
                                    if ($appointment->process_stage === 'lab' && (!$appointment->labTest || $appointment->labTest->status !== 'completed')) {
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

                                {{-- Prescription Section --}}
                                <div class="mb-3">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>Prescription</span>
                                        <button type="button" id="addMedicineBtn" class="btn btn-sm btn-outline-primary">
                                            <i class="zmdi zmdi-plus"></i> Add Medicine
                                        </button>
                                    </label>

                                    <div id="prescriptionList" class="card p-3 bg-light">
                                        <p class="text-muted mb-2">Add prescribed medicines below:</p>
                                        <div id="medicineRows"></div>
                                    </div>

                                    <textarea name="prescription" id="prescriptionText" class="form-control mt-3" rows="4"
                                        readonly placeholder="Generated prescription will appear here..."
                                        @if($disableFields) disabled @endif>{{ old('prescription') }}</textarea>
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
            const labCompleted = {{ $appointment->labTest && $appointment->labTest->status === 'completed' ? 'true' : 'false' }};
            if (labCompleted) {
                formFields.forEach(el => el.disabled = false);
            }

            // Poll lab status every 5 seconds if in lab stage and results not yet filled
            let labPoll;
            @if($appointment->process_stage === 'lab' && (!$appointment->labTest || $appointment->labTest->status !== 'completed'))
                labPoll = setInterval(() => {
                    fetch("{{ url('admin/appointments/' . $appointment->id . '/lab-status') }}", {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'completed') {
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('addMedicineBtn');
            const list = document.getElementById('medicineRows');
            const output = document.getElementById('prescriptionText');
            let medicineCount = 0;

            // Add new medicine row
            addBtn.addEventListener('click', function () {
                medicineCount++;
                const row = document.createElement('div');
                row.className = "row align-items-center mb-2";
                row.innerHTML = `
            <div class="col-md-4 position-relative">
                <input type="hidden" name="medicine_ids[]" class="medicine-id">
                <input type="text" class="form-control form-control-sm medicine-name" 
                    placeholder="Medicine name..." autocomplete="off" required>
                <ul class="list-group position-absolute w-100 shadow-sm mt-1 medicine-suggestions" 
                    style="display:none; z-index:999;"></ul>
            </div>
            <div class="col-md-2">
                <input type="number" name="quantities[]" class="form-control form-control-sm quantity" 
                    placeholder="Qty" min="1" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="dosages[]" class="form-control form-control-sm dosage" 
                    placeholder="Dosage (e.g., 1 tablet 3x daily)" required>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-sm btn-danger remove-btn">
                    <i class="zmdi zmdi-delete"></i>
                </button>
            </div>
        `;
                list.appendChild(row);
            });


            // Remove a medicine row
            list.addEventListener('click', function (e) {
                if (e.target.closest('.remove-btn')) {
                    e.target.closest('.row').remove();
                    updatePrescription();
                }
            });

            // Update prescription text on input
            list.addEventListener('input', function () {
                updatePrescription();
            });

            // Generate formatted prescription text
            function updatePrescription() {
                const names = document.querySelectorAll('.medicine-name');
                const qtys = document.querySelectorAll('.quantity');
                const dosages = document.querySelectorAll('.dosage');
                let lines = [];

                for (let i = 0; i < names.length; i++) {
                    const name = names[i].value.trim();
                    const qty = qtys[i].value.trim();
                    const dose = dosages[i].value.trim();
                    if (name) {
                        let line = `${name}`;
                        if (qty) line += ` ${qty}`;
                        if (dose) line += ` ${dose}`;
                        lines.push(line);
                    }
                }
                output.value = lines.join("\n");
            }

            /**
             * Autocomplete for medicines (search from DB)
             */
            list.addEventListener('input', async function (e) {
                if (!e.target.classList.contains('medicine-name')) return;

                const query = e.target.value.trim();
                const suggestionBox = e.target.nextElementSibling;
                suggestionBox.innerHTML = '';
                if (query.length < 2) {
                    suggestionBox.style.display = 'none';
                    return;
                }

                try {
                    const res = await fetch(`/admin/medicines/search?q=${encodeURIComponent(query)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();

                    if (data.length > 0) {
                        data.forEach(med => {
                            const li = document.createElement('li');
                            li.className = "list-group-item list-group-item-action small";
                            li.innerHTML = `
                            <div><strong>${med.name}</strong> 
                            <small class="text-muted">(${med.form || 'N/A'})</small></div>
                            <small class="text-muted">Stock: ${med.stock_quantity} | KES ${med.unit_price}</small>
                        `;
                            li.addEventListener('click', function () {
                                e.target.value = med.name;
                                e.target.closest('.row').querySelector('.medicine-id').value = med.id;
                                suggestionBox.style.display = 'none';
                                updatePrescription();
                            });
                            suggestionBox.appendChild(li);
                        });
                        suggestionBox.style.display = 'block';
                    } else {
                        suggestionBox.style.display = 'none';
                    }
                } catch (err) {
                    console.error('Autocomplete fetch failed', err);
                }
            });

            // Hide suggestion dropdown on outside click
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.medicine-name') && !e.target.closest('.medicine-suggestions')) {
                    document.querySelectorAll('.medicine-suggestions').forEach(box => box.style.display = 'none');
                }
            });
        });
    </script>

@endsection