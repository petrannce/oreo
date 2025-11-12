<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $billing->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80mm;
            padding: 5px;
            margin-left: 0;
            margin-right: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border-bottom: 1px dashed #000;
            padding: 5px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        hr {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
            }

            .page-break {
                page-break-after: always;
            }
        }

        .text-center {
            text-align: center;
        }

        img.logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            display: block;
            margin: 0 auto 5px;
        }
    </style>
</head>
<body>

@php $hospital = \App\Models\HospitalDetail::first(); @endphp

<div class="container">
    {{-- 🏥 Hospital Header --}}
    <div class="text-center">
        @if($hospital && $hospital->logo)
            <img src="{{ $hospital->logo ? url($hospital->logo) : url('assets/images/default_logo.png') }}" class="logo" alt="Logo">
        @else
            <div style="height:60px;"></div>
        @endif
        <h3>{{ $hospital->name ?? 'Hospital Name' }}</h3>
        <p>
            {{ $hospital->address ?? '' }}<br>
            Tel: {{ $hospital->phone_number ?? '' }}<br>
            {{ $hospital->email ?? '' }}
        </p>
        <hr>
    </div>

    {{-- 🧍 Patient Info --}}
    <p>
        <strong>Patient:</strong> {{ $billing->patient->fname }} {{ $billing->patient->lname }}<br>
        <strong>Bill No:</strong> #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}<br>
        <strong>Date:</strong> {{ $billing->created_at->format('d M Y, h:i A') }}
    </p>

    {{-- 💰 Billing Items --}}
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billing->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">{{ number_format($billing->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <p><strong>Status:</strong> {{ ucfirst($billing->status) }}</p>

    {{-- ✍️ Footer Note --}}
    <div class="text-center">
        <p>Thank you for visiting!<br>Get well soon 💙</p>
    </div>
</div>

</body>
</html>