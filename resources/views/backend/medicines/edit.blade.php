@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Edit Medicine
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('medicines') }}">Medicines</a></li>
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
                        <h2><strong>Edit</strong> Medicine</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <form action="{{ route('medicines.update', $medicine->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row clearfix">
                                {{-- Medicine Name --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Medicine Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $medicine->name }}" required>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="category" class="form-label">Category</label>
                                        <input type="text" name="category" class="form-control" value="{{ $medicine->category }}" placeholder="e.g. Antibiotic, Painkiller">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Form --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="form" class="form-label">Form</label>
                                        <input type="text" name="form" class="form-control" value="{{ $medicine->form }}" placeholder="e.g. Tablet, Syrup">
                                    </div>
                                </div>

                                {{-- Manufacturer --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="manufacturer" class="form-label">Manufacturer</label>
                                        <input type="text" name="manufacturer" class="form-control" value="{{ $medicine->manufacturer }}" placeholder="e.g. Pfizer, GSK">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Stock Quantity --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock_quantity" class="form-control" value="{{ $medicine->stock_quantity }}" min="0" required>
                                    </div>
                                </div>

                                {{-- Unit Price --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="unit_price" class="form-label">Unit Price (Ksh)</label>
                                        <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ $medicine->unit_price }}" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                {{-- Expiry Date --}}
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="date" name="expiry_date" class="form-control" value="{{ $medicine->expiry_date }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Submit Buttons --}}
                            <div class="col-sm-12 mt-3">
                                <button type="submit" class="btn btn-primary btn-round">Update Medicine</button>
                                <a href="{{ route('medicines') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
