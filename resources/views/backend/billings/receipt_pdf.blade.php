<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $billing->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        img.logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            display: block;
            margin: 0 auto 10px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 20pt;
            color: #000;
        }

        .header p {
            margin: 3px 0;
            font-size: 10pt;
            color: #666;
        }

        .patient-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f5f5f5;
            border-left: 4px solid #333;
        }

        .patient-info p {
            margin: 5px 0;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table thead {
            background-color: #333;
            color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            font-weight: bold;
            font-size: 10pt;
        }

        td {
            font-size: 10pt;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        table tfoot {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        table tfoot th {
            background-color: transparent;
            color: #333;
            border-top: 2px solid #333;
        }

        .status-section {
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f8ff;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 9pt;
        }

        .bill-title {
            font-size: 16pt;
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }
    </style>
</head>
<body>

@php $hospital = \App\Models\HospitalDetail::first(); @endphp

<div class="container">
    {{-- Hospital Header --}}
    <div class="header">
        @if($hospital && $hospital->logo)
            <img src="{{ public_path($hospital->logo) }}" class="logo" alt="Hospital Logo">
        @endif
        <h2>{{ $hospital->name ?? 'Hospital Name' }}</h2>
        <p>
            {{ $hospital->address ?? 'Hospital Address' }}<br>
            Tel: {{ $hospital->phone_number ?? 'N/A' }} | Email: {{ $hospital->email ?? 'N/A' }}
        </p>
    </div>

    <div class="text-center bill-title">
        BILLING INVOICE
    </div>

    {{-- Patient Information --}}
    <div class="patient-info">
        <p><strong>Patient Name:</strong> {{ $billing->patient->fname }} {{ $billing->patient->lname }}</p>
        <p><strong>Bill Number:</strong> #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Date Issued:</strong> {{ $billing->created_at->format('d M Y, h:i A') }}</p>
    </div>

    {{-- Billing Items Table --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 40%;">Description</th>
                <th class="text-center" style="width: 15%;">Quantity</th>
                <th class="text-right" style="width: 20%;">Unit Price (KES)</th>
                <th class="text-right" style="width: 20%;">Subtotal (KES)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billing->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTAL AMOUNT</th>
                <th class="text-right">KES {{ number_format($billing->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    {{-- Payment Status --}}
    <div class="status-section">
        <p><strong>Payment Status:</strong> <span style="text-transform: uppercase;">{{ $billing->status }}</span></p>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for choosing {{ $hospital->name ?? 'our hospital' }}.</p>
        <p>For any inquiries, please contact us at {{ $hospital->phone_number ?? 'our office' }}.</p>
        <p style="margin-top: 15px; font-size: 8pt;">This is a computer-generated document. No signature required.</p>
    </div>
</div>

</body>
</html>