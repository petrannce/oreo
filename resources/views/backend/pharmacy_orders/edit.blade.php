@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Edit Pharmacy Order
                        <small>Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders') }}">Pharmacy Orders</a></li>
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
                            <h2><strong>Edit</strong> Pharmacy Order</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <form action="{{ route('pharmacy_orders.update', $pharmacy_order->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row clearfix">
                                    {{-- Patient --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Patient</label>
                                            <input type="text" class="form-control" 
                                                value="{{ $pharmacy_order->patient->fname }} {{ $pharmacy_order->patient->lname }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Doctor --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Doctor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $pharmacy_order->doctor->fname }} {{ $pharmacy_order->doctor->lname }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Medical Record --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Medical Record</label>
                                            <select name="medical_record_id" class="form-control show-tick" required>
                                                <option value="" disabled>-- Select Record --</option>
                                                @foreach($medical_records as $record)
                                                    <option value="{{ $record->id }}" {{ $pharmacy_order->medical_record_id == $record->id ? 'selected' : '' }}>
                                                        Record #{{ $record->id }} ({{ $record->created_at->format('d M Y') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    {{-- Prescription --}}
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="prescription" class="form-label">Prescription</label>
                                            <textarea rows="4" name="prescription" class="form-control no-resize" required>{{ $pharmacy_order->prescription }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    {{-- Status --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control show-tick" required>
                                                <option value="pending" {{ $pharmacy_order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="billed" {{ $pharmacy_order->status == 'billed' ? 'selected' : '' }}>Billed</option>
                                                <option value="dispensed" {{ $pharmacy_order->status == 'dispensed' ? 'selected' : '' }}>Dispensed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-round">Update</button>
                                    <a href="{{ route('pharmacy_orders') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
