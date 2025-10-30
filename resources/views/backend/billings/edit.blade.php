@extends('layouts.backend.header')

@section('content')
    <section class="content">
        <div class="block-header">
            <h2>Billing Items for {{ $billing->patient->fname }} {{ $billing->patient->lname }}</h2>
        </div>

        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="header">
                    <h2><strong>Billing Summary</strong></h2>
                </div>

                <div class="body">
                    {{-- Billing Items Table --}}
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price (Ksh)</th>
                                <th>Subtotal (Ksh)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($billing->items as $item)
                                <tr>
                                    <td><input type="text" value="{{ $item->description }}" class="form-control bg-light"
                                            readonly></td>
                                    <td><input type="number" value="{{ $item->quantity }}" class="form-control bg-light"
                                            readonly></td>
                                    <td><input type="text" value="{{ number_format($item->unit_price, 2) }}"
                                            class="form-control bg-light" readonly></td>
                                    <td><input type="text" value="{{ number_format($item->subtotal, 2) }}"
                                            class="form-control bg-light" readonly></td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-dark text-white">
                                <th colspan="3" class="text-right">Total</th>
                                <th>Ksh {{ number_format($billing->amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    {{-- Update Billing Form --}}
                    <form action="{{ route('billings.update', $billing->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-control">
                                    <option value="cash" {{ $billing->payment_method == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="card" {{ $billing->payment_method == 'card' ? 'selected' : '' }}>Card
                                    </option>
                                    <option value="mpesa" {{ $billing->payment_method == 'mpesa' ? 'selected' : '' }}>M-Pesa
                                    </option>
                                    <option value="insurance" {{ $billing->payment_method == 'insurance' ? 'selected' : '' }}>
                                        Insurance</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="unpaid" {{ $billing->status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                    </option>
                                    <option value="paid" {{ $billing->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="cancelled" {{ $billing->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="text-center mt-4 d-flex flex-wrap justify-content-center gap-2">
                            <button type="submit" class="btn btn-primary btn-round">
                                <i class="zmdi zmdi-refresh"></i> Update Details
                            </button>

                            @if($billing->status === 'paid')
                                <a href="{{ route('billings.show', $billing->id) }}" class="btn btn-success btn-round">
                                    <i class="zmdi zmdi-check"></i> Bill is Ready
                                </a>
                            @endif

                            @if($billing->status === 'paid')
                                <a href="{{ route('billings.resendEmail', $billing->id) }}" class="btn btn-warning btn-round">
                                    <i class="zmdi zmdi-email"></i> Resend Receipt
                                </a>
                            @endif


                            <a href="{{ route('billings') }}" class="btn btn-secondary btn-round">
                                <i class="zmdi zmdi-arrow-left"></i> Back to All Billings
                            </a>

                            <a href="{{ route('billings.receipt', $billing->id) }}" target="_blank"
                                class="btn btn-info btn-round">
                                <i class="zmdi zmdi-print"></i> Print Bill
                            </a>

                            <a href="{{ route('billings.downloadPDF', $billing->id) }}" class="btn btn-dark btn-round">
                                <i class="zmdi zmdi-download"></i> Download PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection