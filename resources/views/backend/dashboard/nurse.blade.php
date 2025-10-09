@extends('layouts.backend.header')

@section('content')
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>
                    Nurse Dashboard
                    <small>Welcome back, {{ auth()->user()->fname }}</small>
                </h2>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{-- Quick Stats --}}
        <div class="row clearfix">

            {{-- Patients Awaiting Triage --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0">
                            {{ $pending_triages_count ?? 0 }}
                        </h3>
                        <p class="text-muted">Patients Awaiting Vitals</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:70%"></div>
                        </div>
                        <small>Record vitals before doctor consultation</small>
                    </div>
                </div>
            </div>

            {{-- Vitals Recorded Today --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0">
                            {{ $today_triages_count ?? 0 }}
                        </h3>
                        <p class="text-muted">Vitals Recorded Today</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:80%"></div>
                        </div>
                        <small>Good job keeping up with patient monitoring!</small>
                    </div>
                </div>
            </div>

            {{-- Admitted Patients --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0">
                            {{ $admitted_patients_count ?? 0 }}
                        </h3>
                        <p class="text-muted">Admitted Patients</p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width:60%"></div>
                        </div>
                        <small>Keep ward records up to date</small>
                    </div>
                </div>
            </div>

            {{-- Completed Triages --}}
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0">
                            {{ $completed_triages_count ?? 0 }}
                        </h3>
                        <p class="text-muted">Completed Triages</p>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width:75%"></div>
                        </div>
                        <small>Patients ready for doctor consultation</small>
                    </div>
                </div>
            </div>

        </div>

        {{-- Patients Waiting for Triage --}}
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Pending</strong> Triage List</h2>
                        <small>Patients who haven’t had their vitals recorded yet</small>
                    </div>
                    <div class="body">
                        <ul class="list-group">
                            @forelse($pending_triages as $triage)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $triage->patient->fname }} {{ $triage->patient->lname }}</strong>
                                        <br>
                                        <small>Appointment: {{ optional($triage->appointment)->date }}</small>
                                    </div>
                                    <a href="{{ route('triages.edit', $triage->id) }}" class="btn btn-sm btn-warning">
                                        Record Vitals
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item text-muted text-center">No patients awaiting vitals</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header"><h2><strong>Quick</strong> Actions</h2></div>
                    <div class="body">
                        <a href="{{ route('triages') }}" class="btn btn-primary btn-block m-b-10">
                            <i class="fa fa-list"></i> View All Triages
                        </a>
                        <a href="{{ route('appointments') }}" class="btn btn-info btn-block m-b-10">
                            <i class="fa fa-calendar"></i> View Appointments
                        </a>
                        <a href="{{ route('patients') }}" class="btn btn-warning btn-block">
                            <i class="fa fa-users"></i> Manage Patients
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
