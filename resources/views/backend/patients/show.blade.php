@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Patient Profile</h2>
                <small class="text-muted">View full medical record, billing, and test history</small>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12 text-right">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients') }}">Patients</a></li>
                    <li class="breadcrumb-item active">{{ $patient->fname }} {{ $patient->lname }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- Patient Basic Info --}}
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="body text-center">
                        <img src="{{ asset('assets/images/patient-placeholder.png') }}" class="rounded-circle mb-3" width="120" alt="Profile Image">
                        <h5 class="mb-1">{{ $patient->fname }} {{ $patient->lname }}</h5>
                        <p class="text-muted">Medical Record #: <strong>{{ $patient->medical_record_number }}</strong></p>
                        <hr>
                        <ul class="list-unstyled text-left">
                            <li><strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</li>
                            <li><strong>Phone:</strong> {{ $patient->phone_number ?? 'N/A' }}</li>
                            <li><strong>Gender:</strong> {{ ucfirst($patient->gender) ?? 'N/A' }}</li>
                            <li><strong>Date of Birth:</strong> {{ $patient->dob ? \Carbon\Carbon::parse($patient->dob)->format('d M Y') : 'N/A' }}</li>
                            <li><strong>Age:</strong> 
                                @if($patient->dob)
                                    {{ \Carbon\Carbon::parse($patient->dob)->age }} years
                                @else
                                    N/A
                                @endif
                            </li>
                            <li><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</li>
                            <li><strong>City:</strong> {{ $patient->city ?? 'N/A' }}</li>
                            <li><strong>Country:</strong> {{ $patient->country ?? 'N/A' }}</li>
                            <li><strong>Created By:</strong> 
                                @if($patient->created_by && \App\Models\User::find($patient->created_by))
                                    {{ \App\Models\User::find($patient->created_by)->name }}
                                @else
                                    System
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Medical History + Tabs --}}
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Patient Details</strong> Overview</h2>
                    </div>

                    <div class="body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#medical" role="tab">Medical Records</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#billings" role="tab">Billings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#labtests" role="tab">Lab Tests</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#consultations" role="tab">Consultations</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- MEDICAL RECORDS --}}
                            <div class="tab-pane active" id="medical" role="tabpanel">
                                @if($patient->medicalRecords && $patient->medicalRecords->count() > 0)
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>Diagnosis</th>
                                                <th>Treatment</th>
                                                <th>Doctor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->medicalRecords as $record)
                                                <tr>
                                                    <td>{{ $record->created_at->format('d M Y') }}</td>
                                                    <td>{{ $record->diagnosis }}</td>
                                                    <td>{{ $record->treatment }}</td>
                                                    <td>{{ $record->doctor->fname ?? 'N/A' }} {{ $record->doctor->lname ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No medical records found.</p>
                                @endif
                            </div>

                            {{-- BILLINGS --}}
                            <div class="tab-pane" id="billings" role="tabpanel">
                                @if($patient->billings && $patient->billings->count() > 0)
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->billings as $billing)
                                                <tr>
                                                    <td>{{ $billing->id }}</td>
                                                    <td>{{ class_basename($billing->billable_type) }}</td>
                                                    <td>${{ number_format($billing->amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $billing->status == 'paid' ? 'success' : ($billing->status == 'unpaid' ? 'warning' : 'secondary') }}">
                                                            {{ ucfirst($billing->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $billing->created_at->format('d M Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No billing records found.</p>
                                @endif
                            </div>

                            {{-- LAB TESTS --}}
                            <div class="tab-pane" id="labtests" role="tabpanel">
                                @if($patient->labTests && $patient->labTests->count() > 0)
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Test Type</th>
                                                <th>Result</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->labTests as $test)
                                                <tr>
                                                    <td>{{ $test->created_at->format('d M Y') }}</td>
                                                    <td>{{ $test->test_type }}</td>
                                                    <td>{{ $test->result ?? 'Pending' }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $test->status == 'completed' ? 'success' : 'info' }}">
                                                            {{ ucfirst($test->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No lab test records available.</p>
                                @endif
                            </div>

                            {{-- CONSULTATIONS --}}
                            <div class="tab-pane" id="consultations" role="tabpanel">
                                @if($patient->consultations && $patient->consultations->count() > 0)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Doctor</th>
                                                <th>Reason</th>
                                                <th>Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($patient->consultations as $consultation)
                                                <tr>
                                                    <td>{{ $consultation->created_at->format('d M Y') }}</td>
                                                    <td>{{ $consultation->doctor->fname ?? 'N/A' }} {{ $consultation->doctor->lname ?? '' }}</td>
                                                    <td>{{ $consultation->reason }}</td>
                                                    <td>{{ $consultation->notes }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">No consultation records found.</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
