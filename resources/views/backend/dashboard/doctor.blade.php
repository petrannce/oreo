@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Doctor Dashboard
                    <small>Welcome back, Dr. {{ auth()->user()->fname }}</small>
                </h2>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{-- Quick Stats --}}
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" 
                            data-from="0" 
                            data-to="{{ $appointments->where('record_date', today())->count() }}" 
                            data-speed="1500">
                            {{ $appointments->where('record_date', today())->count() }}
                        </h3>
                        <p class="text-muted">Today’s Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-green" style="width:80%"></div>
                        </div>
                        <small>Keep up with today’s schedule</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" 
                            data-from="0" 
                            data-to="{{ $appointments->where('status', 'pending')->count() }}" 
                            data-speed="1500">
                            {{ $appointments->where('status', 'pending')->count() }}
                        </h3>
                        <p class="text-muted">Pending Approvals</p>
                        <div class="progress">
                            <div class="progress-bar l-blush" style="width:60%"></div>
                        </div>
                        <small>Appointments awaiting your approval</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" 
                            data-from="0" 
                            data-to="{{ $medical_records->count() }}" 
                            data-speed="1500">
                            {{ $medical_records->count() }}
                        </h3>
                        <p class="text-muted">Medical Records</p>
                        <div class="progress">
                            <div class="progress-bar l-blue" style="width:70%"></div>
                        </div>
                        <small>Total records you’ve added</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" 
                            data-from="0" 
                            data-to="{{ $patients->count() }}" 
                            data-speed="1500">
                            {{ $patients->count() }}
                        </h3>
                        <p class="text-muted">Your Patients</p>
                        <div class="progress">
                            <div class="progress-bar l-orange" style="width:85%"></div>
                        </div>
                        <small>Active patients under your care</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upcoming Appointments Timeline --}}
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Upcoming</strong> Appointments</h2>
                    </div>
                    <div class="body">
                        <ul class="list-group">
                            @forelse($appointments->where('record_date', '>=', today())->take(5) as $appt)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <strong>{{ $appt->patient->user->fname }} {{ $appt->patient->user->lname }}</strong> 
                                        – {{ $appt->record_date->format('d M, Y') }}
                                    </span>
                                    <span class="badge badge-{{ $appt->status == 'approved' ? 'success' : ($appt->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No upcoming appointments</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        {{-- Recent Patients --}}
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card patient_list">
                    <div class="header">
                        <h2><strong>Recent</strong> Patients</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patients->take(10) as $patient)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $patient->fname }} {{ $patient->lname }}</td>
                                            <td>{{ $patient->email ?? 'N/A' }}</td>
                                            <td>
                                                {{ optional($patient->appointments->last())->record_date 
                                                    ? optional($patient->appointments->last())->record_date->format('d M Y') 
                                                    : 'No visits yet' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($patients->count() == 0)
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No patients found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
