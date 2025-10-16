@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Medicine
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">
                            <i class="zmdi zmdi-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('medicines') }}">Medicines</a>
                    </li>
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
                        <h2><strong>Add</strong> Medicine</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <form action="{{ route('medicines.store') }}" method="POST">
                            @csrf

                            <div class="row clearfix">

                                {{-- Medicine Name --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Medicine Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="e.g. Paracetamol" required>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" id="category" class="form-control show-tick">
                                            <option value="">-- Select Category --</option>
                                            <option value="Antibiotic">Antibiotic</option>
                                            <option value="Painkiller">Painkiller</option>
                                            <option value="Antipyretic">Antipyretic</option>
                                            <option value="Antacid">Antacid</option>
                                            <option value="Supplement">Supplement</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="form" class="form-label">Form</label>
                                        <select name="form" id="form" class="form-control show-tick">
                                            <option value="">-- Select Form --</option>
                                            <option value="Tablet">Tablet</option>
                                            <option value="Capsule">Capsule</option>
                                            <option value="Syrup">Syrup</option>
                                            <option value="Injection">Injection</option>
                                            <option value="Cream">Cream</option>
                                            <option value="Ointment">Ointment</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                {{-- Stock Quantity --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                        <input type="number" name="stock_quantity" id="stock_quantity" min="0"
                                            class="form-control" placeholder="e.g. 100" required>
                                    </div>
                                </div>

                                {{-- Unit Price --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="unit_price" class="form-label">Unit Price (KES)</label>
                                        <input type="number" step="0.01" name="unit_price" id="unit_price"
                                            class="form-control" placeholder="e.g. 25.00" required>
                                    </div>
                                </div>

                                {{-- Manufacturer --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="manufacturer" class="form-label">Manufacturer</label>
                                        <input type="text" name="manufacturer" id="manufacturer" class="form-control"
                                            placeholder="e.g. GlaxoSmithKline">
                                    </div>
                                </div>

                            </div>

                            <div class="row clearfix">

                                {{-- Expiry Date --}}
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                                    </div>
                                </div>

                            </div>

                            {{-- Submit --}}
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                                <a href="{{ route('medicines') }}"
                                    class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
