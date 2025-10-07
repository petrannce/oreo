@extends('layouts.backend.header')

@section('content')
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Lab Dashboard
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
                        <h3>{{ $lab_tests->count() }}</h3>
                        <p class="text-muted">Pending Tests</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:75%"></div>
                        </div>
                        <small>Samples awaiting processing</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3>{{ $lab_tests->count() }}</h3>
                        <p class="text-muted">Completed Tests</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:90%"></div>
                        </div>
                        <small>Reports submitted successfully</small>
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
                                    <th>Date Requested</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lab_tests->take(10) as $test)
                                    <tr>
                                        <td>{{ $test->patient->fname }} {{ $test->patient->lname }}</td>
                                        <td>{{ $test->test_name }}</td>
                                        <td>{{ $test->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">No pending tests</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header"><h2><strong>Quick</strong> Actions</h2></div>
                    <div class="body">
                        <a href="{{ route('lab_tests') }}" class="btn btn-danger btn-block">View All Tests</a>
                        <a href="{{ route('lab_tests.create') }}" class="btn btn-outline-primary btn-block">Add Test Result</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
