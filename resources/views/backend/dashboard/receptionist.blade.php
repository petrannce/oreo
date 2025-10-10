@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h2>Reception Dashboard</h2>
                <small class="text-muted">Welcome back, {{ Auth::user()->fname ?? 'Receptionist' }}</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 text-right">
                <a href="{{ route('appointments.create') }}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-plus"></i> New Appointment</a>
                <a href="{{ route('patients.create') }}" class="btn btn-success btn-sm"><i class="zmdi zmdi-accounts"></i> Register Patient</a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Quick Stats -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card top_counter">
                    <div class="body">
                        <div class="icon bg-info"><i class="zmdi zmdi-calendar"></i></div>
                        <div class="content">
                            <div class="text">Today’s Appointments</div>
                            <h5 class="number">{{ $appointments->where('date', today())->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card top_counter">
                    <div class="body">
                        <div class="icon bg-warning"><i class="zmdi zmdi-time"></i></div>
                        <div class="content">
                            <div class="text">Pending Check-ins</div>
                            <h5 class="number">{{ $appointments->where('status','pending')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card top_counter">
                    <div class="body">
                        <div class="icon bg-success"><i class="zmdi zmdi-accounts"></i></div>
                        <div class="content">
                            <div class="text">New Patients</div>
                            <h5 class="number">{{ $patients->where('created_at','>=',now()->startOfMonth())->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card top_counter">
                    <div class="body">
                        <div class="icon bg-danger"><i class="zmdi zmdi-hospital"></i></div>
                        <div class="content">
                            <div class="text">Available Doctors</div>
                            <h5 class="number">{{ $doctors->where('status','available')->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointments Timeline -->
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Today’s Appointments</strong> Timeline</h2>
                    </div>
                    <div class="body">
                        <ul class="timeline list-unstyled">
                            @forelse($appointments->where('date', today())->sortBy('time') as $appointment)
                            <li>
                                <span class="time">{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</span>
                                <div class="content">
                                    <h4>{{ $appointment->patient->user->fname ?? 'Unknown' }} {{ $appointment->patient->user->lname ?? '' }}</h4>
                                    <p>Doctor: <strong>{{ $appointment->doctor->user->fname ?? 'TBD' }}</strong></p>
                                    <span class="badge badge-{{ $appointment->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                            </li>
                            @empty
                            <p class="text-muted">No appointments scheduled today.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        <!-- Patient List -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card patient_list">
                    <div class="header">
                        <h2><strong>Recently Registered Patients</strong></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Patient ID</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Registered On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients->sortByDesc('created_at')->take(5) as $patient)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $patient->user->fname ?? '' }} {{ $patient->user->lname ?? '' }}</td>
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->user->email ?? 'No Email' }}</td>
                                        <td>{{ $patient->user->phone ?? 'No Phone' }}</td>
                                        <td>{{ $patient->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                    @if($patients->isEmpty())
                                    <tr><td colspan="6" class="text-center text-muted">No patients registered yet.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('patients') }}" class="btn btn-sm btn-outline-primary m-t-10 float-right">View All Patients</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection