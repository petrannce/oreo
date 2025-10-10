@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>View Pharmacy Order
                        <small>Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pharmacy_orders') }}">Pharmacy Orders</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>View</strong> Pharmacy Order</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>

                        <div class="body">

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
                                                value="{{ $pharmacy_order->doctor->fname ?? 'N/A' }} {{ $pharmacy_order->doctor->lname ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>

                                    {{-- Medical Record --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Medical Record</label>
                                            <input type="text" class="form-control"
                                                value="{{ $pharmacy_order->medical_record->id ?? 'N/A' }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    {{-- Status --}}
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                            <input type="text" class="form-control" 
                                                value="{{ $pharmacy_order->status }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
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
