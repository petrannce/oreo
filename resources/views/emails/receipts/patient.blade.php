@component('mail::message')
@php
    $hospital = \App\Models\HospitalDetail::first();
@endphp

# Payment Receipt

Dear {{ $billing->patient->fname }} {{ $billing->patient->lname }},

Thank you for your payment. Below are your receipt details:

**Receipt No:** #BILL-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}  
**Date:** {{ $billing->created_at->timezone('Africa/Nairobi')->format('d M Y, h:i A') }}  
**Status:** {{ strtoupper($billing->status) }}

---

@component('mail::table')
| Description | Quantity | Unit Price (KSh) | Subtotal (KSh) |
|:-------------|:----------:|-----------------:|----------------:|
@foreach($billing->items as $item)
| {{ $item->description }} | {{ $item->quantity }} | {{ number_format($item->unit_price, 2) }} | {{ number_format($item->subtotal, 2) }} |
@endforeach
@endcomponent

---

**Total Amount:** KSh {{ number_format($billing->amount, 2) }}  
@if($billing->payment_method)
**Payment Method:** {{ ucfirst($billing->payment_method) }}
@endif

@if($billing->status === 'paid')
✓ Your payment has been successfully received and processed.
@elseif($billing->status === 'pending')
⏳ Your payment is currently being processed.
@endif

We appreciate your visit to {{ $hospital->name ?? config('app.name') }}. We wish you a speedy recovery.

If you have any questions about this receipt, please contact us at {{ $hospital->phone_number ?? config('mail.from.address') }}.

Best regards,  
**{{ $hospital->name ?? config('app.name') }} Team**

---

<small style="color: #999;">This is an automated email. Please do not reply directly to this message.</small>
@endcomponent