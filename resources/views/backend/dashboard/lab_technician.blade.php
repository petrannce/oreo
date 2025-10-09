@extends('layouts.backend.header')

@section('content')
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Lab Technician Dashboard
                    <small>Welcome back, {{ auth()->user()->fname }}</small>
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
                        <h3>{{ $pending_tests->count() }}</h3>
                        <p class="text-muted">Pending Tests</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:70%"></div>
                        </div>
                        <small>Samples awaiting processing</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3>{{ $in_progress_tests->count() }}</h3>
                        <p class="text-muted">In Progress</p>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width:50%"></div>
                        </div>
                        <small>Currently being analyzed</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3>{{ $completed_tests->count() }}</h3>
                        <p class="text-muted">Completed Tests</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:100%"></div>
                        </div>
                        <small>Reports submitted successfully</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3>{{ $total_tests->count() }}</h3>
                        <p class="text-muted">Total Tests</p>
                        <div class="progress">
                            <div class="progress-bar bg-secondary" style="width:90%"></div>
                        </div>
                        <small>All tests handled by you</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending Tests Table --}}
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Pending</strong> Lab Tests</h2>
                    </div>
                    <div class="body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Test Type</th>
                                    <th>Status</th>
                                    <th>Date Requested</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pending_tests->take(10) as $test)
                                    <tr>
                                        <td>{{ $test->patient->fname ?? 'N/A' }} {{ $test->patient->lname ?? '' }}</td>
                                        <td>{{ $test->test_name }}</td>
                                        <td><span class="badge bg-warning text-dark">{{ ucfirst($test->status) }}</span></td>
                                        <td>{{ $test->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('lab_tests.show', $test->id) }}" class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No pending lab tests</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Quick</strong> Actions</h2>
                    </div>
                    <div class="body">
                        <a href="{{ route('lab_tests') }}" class="btn btn-primary btn-block m-b-10">
                            <i class="fa fa-list"></i> View All Lab Tests
                        </a>
                        <a href="{{ route('lab_tests.create') }}" class="btn btn-success btn-block m-b-10">
                            <i class="fa fa-plus"></i> Add New Test
                        </a>
                        <a href="{{ route('appointments') }}" class="btn btn-outline-info btn-block">
                            <i class="fa fa-calendar"></i> View Appointments
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
