@extends('layouts.backend.header')

@section('content')
    <section class="content">
        <div class="container-fluid">

            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @php
                $hospital = \App\Models\HospitalDetail::first();
            @endphp

            <div class="card shadow-lg" id="invoiceCard">
                <div class="card-body">
                    {{-- 🏥 Header Section --}}
                    <div class="row mb-4 border-bottom pb-3 align-items-center">
                        <div class="col-md-2">
                            @if($hospital && $hospital->logo)
                                <img src="{{ asset(path: 'hospitals/logos/'.$hospital->logo) }}" alt="Hospital Logo"
                                    style="width:100%; max-width:100px;">
                            @endif
                        </div>
                        <div class="col-md-10 text-right">
                            <h3 class="font-weight-bold mb-0">{{ $hospital->name ?? 'Hospital Name' }}</h3>
                            <small>{{ $hospital->address ?? '' }}</small><br>
                            <small>Phone: {{ $hospital->phone_number ?? '' }} | Email:
                                {{ $hospital->email ?? '' }}</small><br>
                            <small>Website: {{ $hospital->website ?? '' }}</small>
                        </div>
                    </div>

                    {{-- 🧍 Patient & Billing Info --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Bill To:</h5>
                            <p>
                                <strong>{{ $billing->patient->fname }} {{ $billing->patient->lname }}</strong><br>
                                Patient ID: {{ $billing->patient->id }}<br>
                                Date: {{ $billing->created_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h5 class="font-weight-bold">Invoice Details</h5>
                            <p>
                                Bill No: <strong>#BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</strong><br>
                                Status:
                                <span
                                    class="badge badge-{{ $billing->status == 'paid' ? 'success' : ($billing->status == 'unpaid' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($billing->status) }}
                                </span><br>
                                Payment Method: {{ ucfirst($billing->payment_method ?? 'N/A') }}
                            </p>
                        </div>
                    </div>

                    {{-- 💰 Billing Items Table --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (Ksh)</th>
                                    <th>Subtotal (Ksh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($billing->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 2) }}</td>
                                        <td>{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th>Ksh {{ number_format($billing->amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    {{-- 🧾 Payment Info --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Payment Method:</strong> {{ ucfirst($billing->payment_method ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Status:</strong>
                                <span
                                    class="badge badge-{{ $billing->status == 'paid' ? 'success' : ($billing->status == 'unpaid' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($billing->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- ✍️ Footer Note --}}
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <p class="text-muted">
                                Thank you for choosing {{ $hospital->name ?? 'our hospital' }}.<br>
                                Wishing you a quick recovery.
                            </p>
                        </div>
                    </div>

                    {{-- 🖨️ Print & PDF Buttons --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('billings.receipt', $billing->id) }}" target="_blank"
                            class="btn btn-primary btn-round">
                            <i class="zmdi zmdi-print"></i> Print Bill
                        </a>
                        <a href="#" onclick="downloadPDF()" class="btn btn-dark btn-round">
                            <i class="zmdi zmdi-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 🧾 Optional Print Styles --}}
    <style>
        @media print {

            .btn,
            .alert,
            .breadcrumb,
            .zmdi-home,
            nav,
            header {
                display: none !important;
            }

            #invoiceCard {
                box-shadow: none !important;
                border: none;
            }
        }
    </style>

    {{-- Optional JS PDF Export --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('invoiceCard');
            const opt = {
                margin: 0.5,
                filename: 'Hospital_Invoice_{{ $billing->id }}.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(element).set(opt).save();
        }
    </script>
@endsection