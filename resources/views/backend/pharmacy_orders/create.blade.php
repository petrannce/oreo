@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Pharmacy Order
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.pharmacist') }}"><i class="zmdi zmdi-home"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders') }}">Pharmacy Orders</a></li>
                    <li class="breadcrumb-item active">Add</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Pharmacy Order</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('pharmacy_orders.store') }}" method="POST">
                            @csrf

                            {{-- Appointment Selection --}}
                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="appointment_id">Select Appointment</label>
                                        <select class="form-control show-tick" name="appointment_id" id="appointment_id" required>
                                            <option value="" disabled selected>-- Select Appointment --</option>
                                            @foreach($appointments as $app)
                                                <option value="{{ $app->id }}">
                                                    Appointment #{{ $app->id }} — {{ $app->patient->fname ?? 'Unknown' }} {{ $app->patient->lname ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="patient_id">Select Patient</label>
                                        <select class="form-control show-tick" name="patient_id" id="patient_id" required>
                                            <option value="" disabled selected>-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">
                                                    {{ $patient->fname }} {{ $patient->lname }} - {{ $patient->email }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="doctor_id">Select Doctor</label>
                                        <select class="form-control show-tick" name="doctor_id" id="doctor_id" required>
                                            <option value="" disabled selected>-- Select Doctor --</option>
                                            @foreach($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">
                                                    Dr. {{ $doctor->fname }} {{ $doctor->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="medical_record_id">Select Medical Record</label>
                                        <select class="form-control show-tick" name="medical_record_id" id="medical_record_id" required>
                                            <option value="" disabled selected>-- Select Medical Record --</option>
                                            @foreach($medical_records as $rec)
                                                <option value="{{ $rec->id }}">
                                                    Record #{{ $rec->id }} — {{ $rec->patient->fname ?? 'Unknown' }} {{ $rec->patient->lname ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Order Status --}}
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status">Order Status</label>
                                        <select class="form-control show-tick" name="status" id="status" required>
                                            <option value="pending">Pending</option>
                                            <option value="billed">Billed</option>
                                            <option value="dispensed">Dispensed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                    <a href="{{ route('pharmacy_orders') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div> {{-- body --}}
                </div> {{-- card --}}
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.getElementById('appointment_id').addEventListener('change', function() {
    let appointmentId = this.value;

    fetch(`/appointments/${appointmentId}/details`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Auto-select patient
            const patientSelect = document.getElementById('patient_id');
            patientSelect.value = data.patient.id;

            // Auto-select doctor
            const doctorSelect = document.getElementById('doctor_id');
            doctorSelect.value = data.doctor.id;

            // Auto-select medical record if exists
            const recordSelect = document.getElementById('medical_record_id');
            if (data.medical_record) {
                recordSelect.value = data.medical_record.id;
            } else {
                recordSelect.value = '';
            }
        })
        .catch(error => console.error('Error fetching appointment details:', error));
});
</script>
@endsection
