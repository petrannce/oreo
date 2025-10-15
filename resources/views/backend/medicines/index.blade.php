@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Medicines
                    <small class="text-muted">Welcome to Hospital System</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('medicines') }}">Medicines</a></li>
                    <li class="breadcrumb-item active">All Medicines</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header d-flex justify-content-between align-items-center">
                        <h2><strong>All Medicines</strong></h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{ route('medicines.create') }}" role="button">
                                    Add Medicine
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Form</th>
                                        <th>Stock Qty</th>
                                        <th>Unit Price (Ksh)</th>
                                        <th>Manufacturer</th>
                                        <th>Expiry Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($medicines as $medicine)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $medicine->name }}</td>
                                            <td>{{ $medicine->category ?? '—' }}</td>
                                            <td>{{ $medicine->form ?? '—' }}</td>
                                            <td>{{ $medicine->stock_quantity }}</td>
                                            <td>{{ number_format($medicine->unit_price, 2) }}</td>
                                            <td>{{ $medicine->manufacturer ?? '—' }}</td>
                                            <td>
                                                @if($medicine->expiry_date)
                                                    <span class="{{ \Carbon\Carbon::parse($medicine->expiry_date)->isPast() ? 'text-danger' : '' }}">
                                                        {{ \Carbon\Carbon::parse($medicine->expiry_date)->format('d M, Y') }}
                                                    </span>
                                                @else
                                                    —
                                                @endif
                                            </td>

                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editMedicine({{ $medicine->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('medicines.destroy', $medicine->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this medicine?');">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if($medicines->isEmpty())
                                <div class="text-center text-muted mt-3">
                                    <p>No medicines found. <a href="{{ route('medicines.create') }}">Add one now</a>.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection

<script>
    function editMedicine(id) {
        window.location.href = `/admin/medicines/${id}/edit`;
    }
</script>
