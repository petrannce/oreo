@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <h2>Dashboard
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->count() }}"
                            data-speed="2500" data-fresh-interval="700">
                            {{ $appointments->count() }} <i class="zmdi zmdi-trending-up float-right"></i>
                        </h3>
                        <p class="text-muted">Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-blush" role="progressbar" style="width: 100%;"></div>
                        </div>
                        <small>Total appointments in the system</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-from="0" data-to="{{ $appointments->where('status', 'pending')->count()}}"
                            data-speed="2500" data-fresh-interval="1000">
                            {{  $appointments->where('status', 'pending')->count() }} <i class="zmdi zmdi-trending-up float-right"></i>
                        </h3>
                        <p class="text-muted">Pending Appointments</p>
                        <div class="progress">
                            <div class="progress-bar l-green" role="progressbar" style="width: 100%;"></div>
                        </div>
                        <small>Currently waiting approval</small>
                    </div>
                </div>
            </div>

              <!-- Approved Appointments -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="body">
                <h3 class="number count-to m-b-0"
                    data-from="0"
                    data-to="{{ $appointments->where('status', 'approved')->count() }}"
                    data-speed="2000"
                    data-fresh-interval="700">
                    {{ $appointments->where('status', 'approved')->count() }}
                    <i class="zmdi zmdi-check-circle text-success float-right"></i>
                </h3>
                <p class="text-muted">Approved Appointments</p>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                </div>
                <small>Confirmed & assigned</small>
            </div>
        </div>
    </div>
        </div>

        <div class="row clearfix">
  

    <!-- Rejected Appointments -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="body">
                <h3 class="number count-to m-b-0"
                    data-from="0"
                    data-to="{{ $appointments->where('status', 'rejected')->count() }}"
                    data-speed="2000"
                    data-fresh-interval="700">
                    {{ $appointments->where('status', 'rejected')->count() }}
                    <i class="zmdi zmdi-close-circle text-danger float-right"></i>
                </h3>
                <p class="text-muted">Rejected Appointments</p>
                <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;"></div>
                </div>
                <small>Declined requests</small>
            </div>
        </div>
    </div>

    <!-- Cancelled Appointments -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="body">
                <h3 class="number count-to m-b-0"
                    data-from="0"
                    data-to="{{ $appointments->where('status', 'cancelled')->count() }}"
                    data-speed="2000"
                    data-fresh-interval="700">
                    {{ $appointments->where('status', 'cancelled')->count() }}
                    <i class="zmdi zmdi-alert-circle text-warning float-right"></i>
                </h3>
                <p class="text-muted">Cancelled Appointments</p>
                <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"></div>
                </div>
                <small>Cancelled by patient or doctor</small>
            </div>
        </div>
    </div>

    <!-- Medical Records -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="body">
                <h3 class="number count-to m-b-0"
                    data-from="0"
                    data-to="{{ $medical_records->count() }}"
                    data-speed="2000"
                    data-fresh-interval="700">
                    {{ $medical_records->count() }}
                    <i class="zmdi zmdi-file-text text-info float-right"></i>
                </h3>
                <p class="text-muted">Medical Records</p>
                <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
                </div>
                <small>All records stored in the system</small>
            </div>
        </div>
    </div>
</div>

        <div class="row clearfix">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ ucfirst(auth()->user()->role) }}</strong> Timeline</h2>
                <ul class="header-dropdown">
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="new_timeline">
                    <div class="header">
                        <div class="color-overlay">
                            <div class="day-number">{{ now()->format('d') }}</div>
                            <div class="date-right">
                                <div class="day-name">{{ now()->format('l') }}</div>
                                <div class="month">{{ now()->format('F Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <ul>
                        @if(auth()->user()->role === 'doctor')
                            @foreach($appointments->take(5) as $appt)
                                <li>
                                    <div class="bullet {{ $appt->status == 'approved' ? 'green' : ($appt->status == 'pending' ? 'orange' : 'pink') }}"></div>
                                    <div class="time">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</div>
                                    <div class="desc">
                                        <h3>{{ ucfirst($appt->status) }} Appointment</h3>
                                        <h4>Patient: {{ $appt->patient->fname }} {{ $appt->patient->lname }}</h4>
                                    </div>
                                </li>
                            @endforeach
                        @elseif(auth()->user()->role === 'patient')
                            @foreach($appointments->take(5) as $appt)
                                <li>
                                    <div class="bullet {{ $appt->status == 'approved' ? 'green' : ($appt->status == 'pending' ? 'orange' : 'pink') }}"></div>
                                    <div class="time">{{ \Carbon\Carbon::parse($appt->time)->format('h:i A') }}</div>
                                    <div class="desc">
                                        <h3>{{ ucfirst($appt->status) }} Appointment</h3>
                                        <h4>Doctor: Dr. {{ $appt->doctor->fname }} {{ $appt->doctor->lname }}</h4>
                                    </div>
                                </li>
                            @endforeach
                        @elseif(auth()->user()->role === 'admin')
                            <li>
                                <div class="bullet green"></div>
                                <div class="time">{{ now()->subMinutes(10)->format('h:i A') }}</div>
                                <div class="desc">
                                    <h3>{{ $appointments->count() }} Total Appointments</h3>
                                    <h4>System Overview</h4>
                                </div>
                            </li>
                            <li>
                                <div class="bullet blue"></div>
                                <div class="time">{{ now()->subHours(1)->format('h:i A') }}</div>
                                <div class="desc">
                                    <h3>{{ $medical_records->count() }} Medical Records</h3>
                                    <h4>Data in System</h4>
                                </div>
                            </li>
                            <li>
                                <div class="bullet orange"></div>
                                <div class="time">{{ now()->subHours(2)->format('h:i A') }}</div>
                                <div class="desc">
                                    <h3>{{ \App\Models\User::count() }} Users Registered</h3>
                                    <h4>Doctors | Patients | Admins</h4>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="row clearfix">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Heart</strong> Surgeries <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="line" data-spot-Radius="1"
                            data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(96, 125, 139)"
                            data-spot-Color="rgb(96, 125, 139, 0.7)" data-offset="90" data-width="100%"
                            data-height="50px" data-line-Width="1" data-line-Color="rgb(96, 125, 139, 0.7)"
                            data-fill-Color="rgba(96, 125, 139, 0.3)"> 6,4,7,8,4,3,2,2,5,6,7,4,1,5,7,9,9,8,7,6 </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Medical</strong> Treatment <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="line" data-spot-Radius="1"
                            data-highlight-Spot-Color="rgb(233, 30, 99)" data-highlight-Line-Color="#222"
                            data-min-Spot-Color="rgb(233, 30, 99)" data-max-Spot-Color="rgb(120, 184, 62)"
                            data-spot-Color="rgb(120, 184, 62, 0.7)" data-offset="90" data-width="100%"
                            data-height="50px" data-line-Width="1" data-line-Color="rgb(120, 184, 62, 0.7)"
                            data-fill-Color="rgba(120, 184, 62, 0.3)"> 6,4,7,6,9,3,3,5,7,4,2,3,7,6 </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>New</strong> Patient <small>18% High then last month</small></h2>
                    </div>
                    <div class="body">
                        <div class="sparkline" data-type="bar" data-width="97%" data-height="50px" data-bar-Width="4"
                            data-bar-Spacing="10" data-bar-Color="#00ced1">2,8,5,3,1,7,9,5,6,4,2,3,1</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection