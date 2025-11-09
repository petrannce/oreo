@component('mail::message')
# Payment Receipt

Dear {{ $billing->patient->fname }} {{ $billing->patient->lname }},

Thank you for your payment. Below are your receipt details:

@component('mail::table')
| Description | Quantity | Unit Price | Subtotal |
|:-------------|:----------:|:------------:|:----------:|
@foreach($billing->items as $item)
| {{ $item->description }} | {{ $item->quantity }} | {{ number_format($item->unit_price, 2) }} | {{ number_format($item->subtotal, 2) }} |
@endforeach
@endcomponent

**Total Paid:** KSh {{ number_format($billing->amount, 2) }}  
**Payment Method:** {{ ucfirst($billing->payment_method) }}

We appreciate your visit to {{ config('app.name') }}. We wish you a speedy recovery. Get well soon.

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
