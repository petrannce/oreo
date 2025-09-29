@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Admin Dashboard
                    <small>System Overview & Analytics</small>
                </h2>
            </div>  
            <div class="col-lg-5 col-md-5 col-sm-12 text-right">
                <button class="btn btn-primary btn-sm"><i class="zmdi zmdi-refresh"></i> Refresh</button>
                <button class="btn btn-success btn-sm"><i class="zmdi zmdi-download"></i> Export Report</button>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- Stats Overview --}}
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $appointments->count() }} <i class="zmdi zmdi-calendar-check float-right"></i></h3>
                        <p class="text-muted">Total Appointments</p>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 70%"></div>
                        </div>
                        <small>+12% this month</small>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $appointments->where('status','pending')->count() }} 
                            <i class="zmdi zmdi-time float-right"></i></h3>
                        <p class="text-muted">Pending Appointments</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 50%"></div>
                        </div>
                        <small>Action Required!</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $users->count() }} <i class="zmdi zmdi-accounts float-right"></i></h3>
                        <p class="text-muted">Total Users</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                        <small>+30 New this week</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $resources->count() }} <i class="zmdi zmdi-storage float-right"></i></h3>
                        <p class="text-muted">Resources</p>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width: 60%"></div>
                        </div>
                        <small>Updated regularly</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>📌 Recent Activities</h2>
                    </div>
                    <div class="body">
                        <ul class="list-unstyled activity">
                            <li><i class="zmdi zmdi-plus-circle text-success"></i> New user registered <span class="float-right">2m ago</span></li>
                            <li><i class="zmdi zmdi-calendar text-info"></i> Appointment created <span class="float-right">10m ago</span></li>
                            <li><i class="zmdi zmdi-edit text-warning"></i> Doctor profile updated <span class="float-right">30m ago</span></li>
                            <li><i class="zmdi zmdi-delete text-danger"></i> Resource deleted <span class="float-right">1h ago</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>⚡ Quick Stats</h2>
                    </div>
                    <div class="body">
                        <ul class="list-unstyled">
                            <li>👨‍⚕️ Doctors: <strong>{{ $doctors->count() }}</strong></li>
                            <li>🧑‍🤝‍🧑 Patients: <strong>{{ $patients->count() }}</strong></li>
                            <li>💬 Contacts: <strong>{{ $contacts->count() }}</strong></li>
                            <li>📂 Resources: <strong>{{ $resources->count() }}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
