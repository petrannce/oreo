@extends('layouts.backend.header')

@section('content')

<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12">
                <h2>Pharmacy Dashboard
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
                        <h3>{{ $pharmacy_order_items->count() }}</h3>
                        <p class="text-muted">Total Prescriptions</p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width:85%"></div>
                        </div>
                        <small>All prescriptions handled</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3>{{ $pharmacy_order_items->count() }}</h3>
                        <p class="text-muted">Pending Dispenses</p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width:65%"></div>
                        </div>
                        <small>Pending medication pickups</small>
                    </div>
                </div>
            </div>
        </div>

            {{-- Inventory Actions --}}
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header"><h2><strong>Quick</strong> Actions</h2></div>
                    <div class="body">
                        <a href="{{ route('pharmacy_orders_items') }}" class="btn btn-primary btn-block">View Inventory</a>
                        <a href="{{ route('pharmacy_orders') }}" class="btn btn-outline-success btn-block">Manage Prescriptions</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
