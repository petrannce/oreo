<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bill #{{ $billing->id }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size:12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border-bottom: 1px dashed #000; padding: 5px; text-align: left; }
        .text-right { text-align:right; }
    </style>
</head>
<body>

    @php $hospital = \App\Models\HospitalDetail::first(); @endphp

    <div style="text-align:center;">
        @if($hospital && $hospital->logo)
            <img src="{{ public_path('storage/'.$hospital->logo) }}" style="max-width:60px; margin-bottom:5px;">
        @endif
        <h3>{{ $hospital->name ?? 'Hospital Name' }}</h3>
        <p>{{ $hospital->address ?? '' }}<br>
        Tel: {{ $hospital->phone_number ?? '' }}<br>
        {{ $hospital->email ?? '' }}</p>
        <hr>
    </div>

    <p>
        <strong>Patient:</strong> {{ $billing->patient->fname }} {{ $billing->patient->lname }}<br>
        <strong>Bill No:</strong> #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}<br>
        <strong>Date:</strong> {{ $billing->created_at->format('d M Y, h:i A') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($billing->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right">{{ number_format($billing->amount, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <p><strong>Status:</strong> {{ ucfirst($billing->status) }}</p>
    <p style="text-align:center;">Thank you for visiting! Get well soon 💙</p>

</body>
</html>
