@extends('layouts.backend.header')

@section('content')
<section class="content home">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <h2>Accountant Dashboard
                    <small>Financial Overview & Billing Insights</small>
                </h2>
            </div>  
            <div class="col-lg-4 col-md-4 col-sm-12 text-right">
                <!-- <button class="btn btn-primary btn-sm"><i class="zmdi zmdi-refresh"></i> Refresh</button>
                <button class="btn btn-success btn-sm"><i class="zmdi zmdi-download"></i> Export Summary</button> -->
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{-- Overview Cards --}}
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ number_format($totalRevenue, 2) }} KES 
                            <i class="zmdi zmdi-money float-right text-success"></i>
                        </h3>
                        <p class="text-muted">Total Revenue</p>
                        <small>All time paid invoices</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ number_format($outstandingTotal, 2) }} KES 
                            <i class="zmdi zmdi-alert-circle-o float-right text-warning"></i>
                        </h3>
                        <p class="text-muted">Outstanding Balance</p>
                        <small>Unpaid invoices</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $paidBills }} 
                            <i class="zmdi zmdi-check-all float-right text-info"></i>
                        </h3>
                        <p class="text-muted">Paid Bills</p>
                        <small>Completed payments</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <h3 class="number">{{ $unpaidBills }} 
                            <i class="zmdi zmdi-time float-right text-danger"></i>
                        </h3>
                        <p class="text-muted">Pending Bills</p>
                        <small>Awaiting payment</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Top Billed Services</h2>
                    </div>
                    <div class="body">
                        <ul class="list-unstyled">
                            @foreach ($topServices as $service)
                                <li>
                                    {{ $service->hospitalService->name ?? 'N/A' }}
                                    <span class="float-right text-success">{{ number_format($service->total, 2) }} KES</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Transactions --}}
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Recent Transactions</h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentTransactions as $index => $bill)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bill->patient->fname ?? 'N/A' }}</td>
                                        <td>{{ number_format($bill->amount, 2) }} KES</td>
                                        <td>
                                            <span class="badge badge-{{ $bill->status == 'paid' ? 'success' : ($bill->status == 'unpaid' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $bill->payment_method ?? '-' }}</td>
                                        <td>{{ $bill->created_at->format('d M, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ChartJS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_keys($revenueTrend->toArray())) !!},
        datasets: [{
            label: 'Revenue (KES)',
            data: {!! json_encode(array_values($revenueTrend->toArray())) !!},
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush

@endsection
@section('title', 'Accountant Dashboard')