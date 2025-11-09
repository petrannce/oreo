@extends('layouts.backend.print')

@section('title', 'Receipt - ' . ($billing->patient->fname ?? 'Patient'))

@section('content')
    <div class="container-fluid">

        @php
            $hospital = \App\Models\HospitalDetail::first();
        @endphp

        <div id="receiptPrint" class="p-3" style="max-width: 80mm; margin: auto; font-family: 'Courier New', monospace;">

            {{-- 🏥 Hospital Header --}}
            <div class="text-center">
                @if($hospital && $hospital->logo)
                    <img src="{{ asset('storage/' . $hospital->logo) }}" alt="Logo" style="max-width:60px; margin-bottom:5px;">
                @endif
                <h5 style="margin:0;">{{ $hospital->name ?? 'Hospital Name' }}</h5>
                <small>{{ $hospital->address ?? '' }}</small><br>
                <small>Tel: {{ $hospital->phone_number ?? '' }}</small><br>
                <small>{{ $hospital->email ?? '' }}</small>
                <hr style="border-top: 1px dashed #000; margin:5px 0;">
            </div>

            {{-- 🧍 Patient Info --}}
            <div style="font-size:13px;">
                <strong>Patient:</strong> {{ $billing->patient->fname }} {{ $billing->patient->lname }}<br>
                <strong>Bill No:</strong> #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Date:</strong> {{ $billing->created_at->timezone('Africa/Nairobi')->format('d M Y, h:i A') }}
            </div>

            <hr style="border-top: 1px dashed #000; margin:5px 0;">

            {{-- 💰 Items List --}}
            <table style="width:100%; font-size:13px;">
                <thead>
                    <tr>
                        <th style="text-align:left;">Item</th>
                        <th style="text-align:right;">Amt</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billing->items as $item)
                        <tr>
                            <td style="text-align:left;">
                                {{ $item->description }} (x{{ $item->quantity }})
                            </td>
                            <td style="text-align:right;">
                                {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr style="border-top: 1px dashed #000; margin:5px 0;">

            {{-- 🔢 Totals --}}
            <table style="width:100%; font-size:13px;">
                <tr>
                    <td style="text-align:left;">Total:</td>
                    <td style="text-align:right; font-weight:bold;">
                        Ksh {{ number_format($billing->amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;">Status:</td>
                    <td style="text-align:right;">
                        {{ strtoupper($billing->status) }}
                    </td>
                </tr>
            </table>

            <hr style="border-top: 1px dashed #000; margin:5px 0;">

            {{-- ✍️ Footer --}}
            <div class="text-center" style="font-size:12px;">
                Thank you for visiting!<br>
                Get well soon 💙<br>
                {{ $hospital->website ?? '' }}
            </div>
        </div>

        {{-- 🖨️ Print Button --}}
        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-round">
                <i class="zmdi zmdi-print"></i> Print Receipt
            </button>
        </div>
    </div>

    {{-- 🧾 Print Styles --}}
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        @media print {
            body {
                background: #fff;
            }

            body * {
                visibility: hidden;
            }

            #receiptPrint,
            #receiptPrint * {
                visibility: visible;
            }

            #receiptPrint {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
                padding: 0;
                margin: 0;
            }

            .no-print,
            button,
            .btn {
                display: none !important;
            }
        }
    </style>
@endsection