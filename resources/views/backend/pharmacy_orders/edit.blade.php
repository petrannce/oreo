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
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pharmacy_orders') }}">Pharmacy Orders</a>
                    </li>
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
                    </div>

                    <div class="body">
                        {{-- ✅ Normal Laravel Form --}}
                        <form action="{{ route('pharmacy_orders.update', $pharmacy_order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">

                                {{-- Appointment ID --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Appointment ID</label>
                                        <input type="text" name="appointment_id" class="form-control"
                                            value="{{ $pharmacy_order->appointment_id }}" readonly>
                                    </div>
                                </div>

                                {{-- Patient --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Patient</label>
                                        <input type="hidden" name="patient_id" value="{{ $pharmacy_order->patient_id }}">
                                        <input type="text" class="form-control"
                                            value="{{ $pharmacy_order->patient->fname }} {{ $pharmacy_order->patient->lname }}"
                                            readonly>
                                    </div>
                                </div>

                                {{-- Doctor --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Doctor</label>
                                        <input type="hidden" name="doctor_id" value="{{ $pharmacy_order->doctor_id }}">
                                        <input type="text" class="form-control"
                                            value="{{ $pharmacy_order->doctor->fname }} {{ $pharmacy_order->doctor->lname }}"
                                            readonly>
                                    </div>
                                </div>

                                {{-- Medical Record --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Medical Record</label>
                                        <input type="hidden" name="medical_record_id" value="{{ $pharmacy_order->medical_record_id }}">
                                        <input type="text" class="form-control"
                                            value="Record #{{ $pharmacy_order->medical_record_id }} ({{ $pharmacy_order->medical_record->created_at->format('d M Y') }})"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Prescription --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="prescription" class="form-label">Prescription</label>
                                        <textarea rows="6" class="form-control no-resize" readonly>{{ $prescriptionText }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Notes --}}
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="prescription" class="form-label">Notes</label>
                                        <textarea rows="6" class="form-control no-resize" readonly>{{ $pharmacy_order->medical_record->notes }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Total Price --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Total Price (KES)</label>
                                        <input type="text" class="form-control" name="total_price"
                                            value="{{ $pharmacy_order->total_price }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Status --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-control show-tick">
                                            <option value="pending" {{ $pharmacy_order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="billed" {{ $pharmacy_order->status == 'billed' ? 'selected' : '' }}>Billed</option>
                                            <option value="dispensed" {{ $pharmacy_order->status == 'dispensed' ? 'selected' : '' }}>Dispensed</option>
                                            <option value="finalised" {{ $pharmacy_order->status == 'finalised' ? 'selected' : '' }}>Finalised</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-round">Update</button>
                                <a href="{{ route('pharmacy_orders') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- ✅ Success/Error Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
