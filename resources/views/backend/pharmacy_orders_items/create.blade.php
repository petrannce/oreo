@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Pharmacy Order Items
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.pharmacist_items') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders_items') }}">Pharmacy Orders Item</a></li>
                    <li class="breadcrumb-item active">Add Item</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Item to Pharmacy Order</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <form action="{{ route('pharmacy_orders_items.store') }}" method="POST">
                            @csrf

                            <div class="row clearfix">
                                {{-- Pharmacy Order --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pharmacy_order_id" class="form-label">Pharmacy Order</label>
                                        <select class="form-control show-tick" name="pharmacy_order_id" id="pharmacy_order_id" required>
                                            <option value="" disabled selected>-- Select Order --</option>
                                            @foreach($pharmacy_orders as $order)
                                                <option value="{{ $order->id }}">
                                                    Order #{{ $order->id }} - Patient: {{ $order->patient->fname }} {{ $order->patient->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Drug Name --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="drug_name" class="form-label">Drug Name</label>
                                        <input type="text" name="drug_name" class="form-control" placeholder="e.g. Amoxicillin" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Quantity --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="number" name="quantity" class="form-control" placeholder="e.g. 10" min="1" required>
                                    </div>
                                </div>

                                {{-- Dosage --}}
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="dosage" class="form-label">Dosage Instructions</label>
                                        <input type="text" name="dosage" class="form-control" placeholder="e.g. Take 1 tablet twice daily">
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Add Item</button>
                                    <a href="{{ route('pharmacy_orders_items') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
