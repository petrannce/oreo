@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Add Pharmacy Order
                        <small>Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.pharmacist') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders') }}">Pharmacy Orders</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Pharmacy Order </h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <form action="{{ route('pharmacy_orders.store') }}" method="POST">
                                @csrf

                                <div class="row clearfix">

                                    {{-- Select Patient --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="patient_id" class="form-label">Select Patient</label>
                                            <select class="form-control show-tick" name="patient_id" id="patient_id"
                                                required>
                                                <option value="" selected disabled>-- Select Patient --</option>
                                                @foreach($patients as $patient)
                                                    <option value="{{ $patient->id }}">
                                                        {{ $patient->fname }} {{ $patient->lname }} - {{ $patient->email }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Select Doctor --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="doctor_id" class="form-label">Select Doctor</label>
                                            <select class="form-control show-tick" name="doctor_id" id="doctor_id" required>
                                                <option value="" selected disabled>-- Select Doctor --</option>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">
                                                        Dr. {{ $doctor->fname }} {{ $doctor->lname }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Select Medical Record --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="medical_record_id" class="form-label">Medical Record</label>
                                            <select class="form-control show-tick" name="medical_record_id"
                                                id="medical_record_id" required>
                                                <option value="" selected disabled>-- Select Record --</option>
                                                @foreach($medical_records as $record)
                                                    <option value="{{ $record->id }}">
                                                        Record #{{ $record->id }} - {{ $record->record_date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                {{-- Prescription --}}
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="prescription" class="form-label">Prescription</label>
                                            <textarea rows="3" name="prescription" class="form-control no-resize"
                                                placeholder="Enter prescribed medicines..." required></textarea>
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Order Status</label>
                                            <select class="form-control show-tick" name="status" id="status" required>
                                                <option value="pending">Pending</option>
                                                <option value="billed">Billed</option>
                                                <option value="dispensed">Dispensed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                        <a href="{{ route('pharmacy_orders') }}"
                                            class="btn btn-default btn-round btn-simple">Cancel</a>
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