@extends('layouts.backend.print')

@section('title', 'Receipt - ' . ($billing->patient->fname ?? 'Patient'))

@section('content')
    <div class="container-fluid">

        @php
            $hospital = \App\Models\HospitalDetail::first();
        @endphp

        <div id="receiptPrint" class="p-3" style="max-width: 80mm; margin: auto; font-family: 'Courier New', Courier, monospace;">

            {{-- Hospital Header --}}
            <div class="text-center">
                @if($hospital && $hospital->logo)
                    @php
                        $logoPath = public_path($hospital->logo);
                        $logoExists = file_exists($logoPath);
                    @endphp
                    @if($logoExists)
                        <img src="{{ asset($hospital->logo) }}" alt="Logo" style="max-width:60px; max-height:60px; margin-bottom:5px; display:block; margin-left:auto; margin-right:auto;">
                    @endif
                @endif
                <h5 style="margin:5px 0; font-size:16px; font-weight:bold;">{{ $hospital->name ?? 'Hospital Name' }}</h5>
                <div style="font-size:11px; line-height:1.4;">
                    {{ $hospital->address ?? '' }}<br>
                    Tel: {{ $hospital->phone_number ?? '' }}<br>
                    {{ $hospital->email ?? '' }}
                </div>
                <hr style="border:none; border-top: 1px dashed #000; margin:8px 0;">
            </div>

            {{-- Receipt Title --}}
            <div class="text-center" style="margin:5px 0;">
                <strong style="font-size:14px;">RECEIPT</strong>
            </div>

            {{-- Patient Info --}}
            <div style="font-size:12px; margin-bottom:8px;">
                <strong>Patient:</strong> {{ $billing->patient->fname }} {{ $billing->patient->lname }}<br>
                <strong>Bill No:</strong> #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}<br>
                <strong>Date:</strong> {{ $billing->created_at->timezone('Africa/Nairobi')->format('d M Y, h:i A') }}
            </div>

            <hr style="border:none; border-top: 1px dashed #000; margin:5px 0;">

            {{-- Items List --}}
            <table style="width:100%; font-size:11px; border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #000;">
                        <th style="text-align:left; padding:3px 0; font-weight:bold;">Item</th>
                        <th style="text-align:center; padding:3px 5px; font-weight:bold;">Qty</th>
                        <th style="text-align:right; padding:3px 0; font-weight:bold;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($billing->items as $item)
                        <tr style="border-bottom: 1px dashed #ddd;">
                            <td style="text-align:left; padding:5px 0;">
                                {{ $item->description }}
                            </td>
                            <td style="text-align:center; padding:5px 5px;">
                                {{ $item->quantity }}
                            </td>
                            <td style="text-align:right; padding:5px 0;">
                                {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr style="border:none; border-top: 1px solid #000; margin:8px 0;">

            {{-- Totals --}}
            <table style="width:100%; font-size:13px; margin-bottom:5px;">
                <tr>
                    <td style="text-align:left; padding:3px 0;">
                        <strong>TOTAL:</strong>
                    </td>
                    <td style="text-align:right; padding:3px 0; font-weight:bold; font-size:14px;">
                        Ksh {{ number_format($billing->amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left; padding:3px 0;">Status:</td>
                    <td style="text-align:right; padding:3px 0;">
                        <strong>{{ strtoupper($billing->status) }}</strong>
                    </td>
                </tr>
            </table>

            <hr style="border:none; border-top: 1px dashed #000; margin:8px 0;">

            {{-- Footer --}}
            <div class="text-center" style="font-size:11px; line-height:1.5;">
                <p style="margin:5px 0;">Thank you for visiting!</p>
                <p style="margin:5px 0;">Get well soon</p>
                @if($hospital && $hospital->website)
                    <p style="margin:5px 0;">{{ $hospital->website }}</p>
                @endif
                <p style="margin:8px 0; font-size:9px;">
                    Printed: {{ now()->timezone('Africa/Nairobi')->format('d/m/Y h:i A') }}
                </p>
            </div>
        </div>

        {{-- Print Button --}}
        <div class="text-center mt-4 no-print" id="printButton">
            <button onclick="window.print()" class="btn btn-primary btn-round">
                <i class="zmdi zmdi-print"></i> Print Receipt
            </button>
        </div>
    </div>

    {{-- Print Styles --}}
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        #receiptPrint {
            background: white;
        }

        @media print {
            body {
                background: #fff;
                margin: 0;
                padding: 0;
            }

            /* Hide everything except receipt */
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
                padding: 5mm;
                margin: 0;
            }

            /* Hide print button and navigation */
            .no-print,
            #printButton,
            button,
            .btn,
            nav,
            header,
            footer,
            .sidebar {
                display: none !important;
                visibility: hidden !important;
            }

            /* Ensure images print */
            img {
                max-width: 60px !important;
                height: auto !important;
                display: block !important;
            }

            /* Force print colors */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }

        /* Screen view styling */
        @media screen {
            #receiptPrint {
                border: 1px solid #ddd;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                margin-top: 20px;
                margin-bottom: 20px;
                background: white;
            }
        }
    </style>

    {{-- Auto-focus print button --}}
    <script>
        // Optional: Auto-print when page loads (comment out if not needed)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };

        // Keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
@endsection