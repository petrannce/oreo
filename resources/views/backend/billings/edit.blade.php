@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Billing
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('billings') }}">Billings</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Edit</strong> Billing</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('billings.update', $billing->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <input type="text" class="form-control" 
                                            value="{{ $billing->patient->fname }} {{ $billing->patient->lname }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Billable Type</label>
                                        <input type="text" class="form-control" 
                                            value="{{ class_basename($billing->billable_type) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Billable ID</label>
                                        <input type="text" class="form-control" value="{{ $billing->billable_id }}" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ $billing->amount }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select name="payment_method" class="form-control show-tick">
                                            <option value="cash" {{ $billing->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="card" {{ $billing->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                            <option value="mpesa" {{ $billing->payment_method == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                            <option value="insurance" {{ $billing->payment_method == 'insurance' ? 'selected' : '' }}>Insurance</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control show-tick" required>
                                            <option value="unpaid" {{ $billing->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                            <option value="paid" {{ $billing->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="cancelled" {{ $billing->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Update</button>
                                    <a href="{{ route('billings') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
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
