@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Nurse Dashboard
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
                        <h3 class="number count-to m-b-0" data-to="{{ $triages->count() }}">
                            {{ $triages->count() }}
                        </h3>
                        <p class="text-muted">Patients Awaiting Vitals</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:70%"></div>
                        </div>
                        <small>Record vitals before doctor consultation</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-to="{{ $triages->count() }}">
                            {{ $triages->count() }}
                        </h3>
                        <p class="text-muted">Vitals Recorded Today</p>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width:80%"></div>
                        </div>
                        <small>Good job keeping up with patient monitoring!</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number count-to m-b-0" data-to="{{ $triages->count() }}">
                            {{ $triages->count() }}
                        </h3>
                        <p class="text-muted">Admitted Patients</p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width:60%"></div>
                        </div>
                        <small>Keep ward records up to date</small>
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
                    </div>
                    <div class="body">
                        <ul class="list-group">
                            @forelse($triages->take(6) as $p)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><strong>{{ $p->patient->fname }} {{ $p->patient->lname }}</strong></span>
                                    <span class="badge badge-warning">Awaiting</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">No patients awaiting vitals</li>
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
                        <a href="{{ route('triages.create') }}" class="btn btn-success btn-block m-b-10">Start Triage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
