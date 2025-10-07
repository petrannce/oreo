@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Create Billing
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('billings') }}">Billings</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Billing</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('billings.store') }}" method="POST">
                            @csrf

                            <div class="row clearfix">
                                {{-- Select Patient --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="patient_id" class="form-label">Patient</label>
                                        <select name="patient_id" class="form-control show-tick" required>
                                            <option value="" disabled selected>-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">
                                                    {{ $patient->fname }} {{ $patient->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Billable Type --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="billable_type" class="form-label">Billable Type</label>
                                        <select name="billable_type" class="form-control show-tick" required>
                                            <option value="App\\Models\\PharmacyOrder">Pharmacy Order</option>
                                            <option value="App\\Models\\LabTest">Lab Test</option>
                                            <option value="App\\Models\\Consultation">Consultation</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Billable ID --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="billable_id" class="form-label">Billable ID</label>
                                        <input type="number" name="billable_id" class="form-control" placeholder="Enter Billable ID" required>
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="Enter Amount" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Payment Method --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select name="payment_method" class="form-control show-tick">
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="mpesa">M-Pesa</option>
                                            <option value="insurance">Insurance</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-control show-tick" required>
                                            <option value="unpaid" selected>Unpaid</option>
                                            <option value="paid">Paid</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Save</button>
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
