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
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Billings</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All Billings</strong></h2>
                        <ul class="header-dropdown">
                        </ul>
                    </div>

                    @include('layouts.partials.filter',[
                            'filterRoute' => route('billings'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'billings',
                            ])

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Patient</th>
                                        <th>Billable Type</th>
                                        <th>Billable ID</th>
                                        <th>Amount</th>
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
                                                <a href="{{ route('billings.edit', $billing->id) }}" class="btn btn-icon btn-neutral btn-icon-mini">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <form action="{{ route('billings.destroy', $billing->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this billing?');">
                                                        <i class="zmdi zmdi-delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
