@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Pharmacy Orders
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{route('pharmacy_orders')}}">Pharmacy Orders</a></li>
                    <li class="breadcrumb-item active">Pharmacy Orders</li>
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
                        <h2><strong>All Pharmacy Orders</strong> </h2>
                        <ul class="header-dropdown">
                        </ul>
                    </div>

                    @include('layouts.partials.filter',[
                            'filterRoute' => route('pharmacy_orders'),
                            'reportRoute' => route('reports.generate'),
                            'extraFilters' => [],
                            'type' => 'pharmacy_orders',
                            ])

                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Full Name</th>
                                        <th>License Number</th>
                                        <th>Deparment</th>
                                        <th>Employee Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($pharmacy_orders as $pharmacy_order)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$pharmacy_order->user->fname}} {{$pharmacy_order->user->lname}}</td>
                                            <td>{{$pharmacy_order->license_number  }}</td>
                                            <td>{{$pharmacy_order->department}}</td>
                                            <td>{{$pharmacy_order->employee_code  }}</td>
                                            <td>{{$pharmacy_order->user->profile?->status ?? 'No Status'}}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-icon btn-neutral btn-icon-mini"
                                                    onclick="editPharmacyOrder({{ $pharmacy_order->id }})">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('pharmacy_orders.destroy', $nurse->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-neutral btn-icon-mini"
                                                        onclick="return confirm('Are you sure you want to delete this pharmacy order?');">
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

<script>
    function editPharmacyOrder(pharmacy_orderId) {
        window.location.href = `/admin/pharmacy_orders/${pharmacy_orderId}/edit`;
    }
</script>