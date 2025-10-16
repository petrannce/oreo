@extends('layouts.backend.header')

@section('content')

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Billings
                        <small class="text-muted">Welcome to Hospital System</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i>
                                Dashboard</a></li>
                        <li class="breadcrumb-item active">Billings</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header d-flex justify-content-between align-items-center">
                            <h2><strong>All Billings</strong></h2>
                            <a class="btn btn-primary btn-lg" href="{{ route('billings.create') }}">
                                <i class="zmdi zmdi-plus"></i> Add Billing
                            </a>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Type</th>
                                            <th>Bill ID</th>
                                            <th>Amount (Ksh)</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($billings as $billing)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $billing->patient->fname }} {{ $billing->patient->lname }}</td>
                                                <td>{{ class_basename($billing->billable_type) }}</td>
                                                <td>{{ $billing->billable_id }}</td>
                                                <td>{{ number_format($billing->amount, 2) }}</td>
                                                <td>{{ $billing->payment_method ?? '-' }}</td>
                                                <td>
                                                    <span class="badge 
                                                            @if($billing->status == 'paid') badge-success
                                                            @elseif($billing->status == 'unpaid') badge-warning
                                                            @else badge-danger
                                                            @endif">
                                                        {{ ucfirst($billing->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{-- Dropdown for multiple actions --}}
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                                            data-toggle="dropdown">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            {{-- Edit --}}
                                                            <a class="dropdown-item"
                                                                href="{{ route('billings.edit', $billing->id) }}">
                                                                <i class="zmdi zmdi-edit"></i> Edit
                                                            </a>

                                                            {{-- Mark as Paid / Bill Ready --}}
                                                            @if($billing->status != 'paid')
                                                                <a class="dropdown-item text-success"
                                                                    href="{{ route('billings.edit', $billing->id) }}">
                                                                    <i class="zmdi zmdi-check-circle"></i> Mark as Paid
                                                                </a>
                                                            @endif

                                                            {{-- Print Bill --}}
                                                            <a class="dropdown-item text-primary"
                                                                href="{{ route('billings.receipt', $billing->id) }}"
                                                                target="_blank">
                                                                <i class="zmdi zmdi-print"></i> Print Bill
                                                            </a>

                                                            {{-- Download PDF --}}
                                                            <a class="dropdown-item text-dark"
                                                                href="{{ route('billings.downloadPDF', $billing->id) }}">
                                                                <i class="zmdi zmdi-download"></i> Download PDF
                                                            </a>


                                                            {{-- Delete --}}
                                                            <form action="{{ route('billings.destroy', $billing->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this billing?');">
                                                                    <i class="zmdi zmdi-delete"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- body -->
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection