@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Edit Pharmacy Order Item
                        <small>Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders_items') }}">Pharmacy Order Items</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Edit</strong> Pharmacy Order Item</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <form action="{{ route('pharmacy_orders_items.update', $pharmacy_order_item->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row clearfix">
                                    {{-- Parent Order Reference --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Order #</label>
                                            <input type="text" name="pharmacy_order_id" class="form-control" 
                                                value="{{ $pharmacy_order_item->pharmacyOrder->id }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Medicine --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Medicine</label>
                                            <select name="medicine_id" class="form-control show-tick" required>
                                                <option value="" disabled>-- Select Medicine --</option>
                                                @foreach($medicines as $medicine)
                                                    <option value="{{ $medicine->id }}" 
                                                        {{ $pharmacy_order_item->medicine_id == $medicine->id ? 'selected' : '' }}>
                                                        {{ $medicine->name }} ({{ $medicine->stock }} in stock)
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    {{-- Quantity --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" name="quantity" class="form-control" 
                                                value="{{ $pharmacy_order_item->quantity }}" min="1" required>
                                        </div>
                                    </div>

                                    {{-- Dosage --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Dosage</label>
                                            <input type="text" name="dosage" class="form-control" 
                                                value="{{ $pharmacy_order_item->dosage }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Price --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Price per Unit</label>
                                            <input type="number" name="unit_price" step="0.01" class="form-control" 
                                                value="{{ $pharmacy_order_item->unit_price }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Subtotal --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Total Price</label>
                                            <input type="number" name="subtotal" step="0.01" class="form-control" 
                                                value="{{ $pharmacy_order_item->subtotal }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control show-tick" required>
                                                <option value="pending" {{ $pharmacy_order_item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="billed" {{ $pharmacy_order_item->status == 'billed' ? 'selected' : '' }}>Billed</option>
                                                <option value="dispensed" {{ $pharmacy_order_item->status == 'dispensed' ? 'selected' : '' }}>Dispensed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Update</button>
                                    <a href="{{ route('pharmacy_orders_items') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
