@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>
                    Edit Pharmacy Order
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
        <div class="row clearfix justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="header bg-primary text-white px-4 py-3 rounded-top">
                        <h5 class="mb-0"><i class="zmdi zmdi-edit"></i> Edit Pharmacy Order</h5>
                    </div>

                    <div class="body px-4 py-4">
                        <form action="{{ route('pharmacy_orders.update', $pharmacy_order->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- ================= BASIC INFORMATION ================= --}}
                            <h6 class="font-weight-bold text-uppercase text-muted mb-3">Basic Information</h6>
                            <div class="row">
                                {{-- Appointment ID --}}
                                <div class="col-md-3 mb-3">
                                    <label>Appointment ID</label>
                                    <input type="text" name="appointment_id" class="form-control" value="{{ $pharmacy_order->appointment_id }}" readonly>
                                </div>

                                {{-- Patient --}}
                                <div class="col-md-3 mb-3">
                                    <label>Patient</label>
                                    <input type="hidden" name="patient_id" value="{{ $pharmacy_order->patient_id }}">
                                    <input type="text" class="form-control" value="{{ $pharmacy_order->patient->fname }} {{ $pharmacy_order->patient->lname }}" readonly>
                                </div>

                                {{-- Doctor --}}
                                <div class="col-md-3 mb-3">
                                    <label>Doctor</label>
                                    <input type="hidden" name="doctor_id" value="{{ $pharmacy_order->doctor_id }}">
                                    <input type="text" class="form-control" value="{{ $pharmacy_order->doctor->fname }} {{ $pharmacy_order->doctor->lname }}" readonly>
                                </div>

                                {{-- Medical Record --}}
                                <div class="col-md-3 mb-3">
                                    <label>Medical Record</label>
                                    <input type="hidden" name="medical_record_id" value="{{ $pharmacy_order->medical_record_id }}">
                                    <input type="text" class="form-control" value="Record #{{ $pharmacy_order->medical_record_id }} ({{ $pharmacy_order->medical_record->created_at->format('d M Y') }})" readonly>
                                </div>
                            </div>

                            <hr>

                            {{-- ================= PRESCRIPTIONS ================= --}}
                            <h6 class="font-weight-bold text-uppercase text-muted mb-3">Prescriptions</h6>
                            <div class="form-group">
                                <textarea rows="5" class="form-control no-resize" readonly>{{ $prescriptionText }}</textarea>
                            </div>

                            {{-- ================= LAB TESTS ================= --}}
                            <h6 class="font-weight-bold text-uppercase text-muted mb-3">Lab Tests</h6>
                            <div class="form-group">
                                <textarea rows="5" class="form-control no-resize" readonly>{{ $labTestsText ?? 'No lab tests available' }}</textarea>
                            </div>

                            {{-- ================= DOCTOR'S NOTES ================= --}}
                            <h6 class="font-weight-bold text-uppercase text-muted mb-3">Doctor’s Notes</h6>
                            <div class="form-group">
                                <textarea rows="5" class="form-control no-resize" readonly>{{ $pharmacy_order->medical_record->notes }}</textarea>
                            </div>

                            {{-- ================= TOTALS AND STATUS ================= --}}
                            @php
                                $labTotal = $pharmacy_order->appointment->labTests->sum(function ($lab) {
                                    return $lab->labService->price ?? 0;
                                });
                                $totalPrice = ($pharmacy_order->total_price ?? 0) + $labTotal;
                            @endphp

                            <div class="row">
                                {{-- Total Price --}}
                                <div class="col-md-4 mb-3">
                                    <label>Total Price (KES)</label>
                                    <input type="text" class="form-control" name="total_price" value="{{ $totalPrice }}" readonly>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="pending" {{ $pharmacy_order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="billed" {{ $pharmacy_order->status == 'billed' ? 'selected' : '' }}>Billed</option>
                                        <option value="dispensed" {{ $pharmacy_order->status == 'dispensed' ? 'selected' : '' }}>Dispensed</option>
                                        <option value="finalised" {{ $pharmacy_order->status == 'finalised' ? 'selected' : '' }}>Finalised</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ================= ACTION BUTTONS ================= --}}
                            <div class="mt-4 text-right">
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="zmdi zmdi-check"></i> Update
                                </button>
                                <a href="{{ route('pharmacy_orders') }}" class="btn btn-secondary btn-round btn-simple">
                                    <i class="zmdi zmdi-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ✅ Alerts --}}
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
