@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Create Billing
                    <small>Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('billings') }}">Billings</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add</strong> Billing</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('billings.store') }}" method="POST">
                            @csrf

                            {{-- Patient + Payment --}}
                            <div class="row clearfix mb-3">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="patient_id">Patient</label>
                                        <select name="patient_id" class="form-control show-tick"
                                            onchange="location.href='{{ route('billings.create') }}?patient_id=' + this.value"
                                            required>
                                            <option value="" selected disabled>-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->fname }} {{ $patient->lname }}{{ $patient->email ? ' - '.$patient->email : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method</label>
                                        <select name="payment_method" class="form-control show-tick">
                                            <option value="cash" {{ old('payment_method', $payment_method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="card" {{ old('payment_method', $payment_method ?? '') == 'card' ? 'selected' : '' }}>Card</option>
                                            <option value="mpesa" {{ old('payment_method', $payment_method ?? '') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                                            <option value="insurance" {{ old('payment_method', $payment_method ?? '') == 'insurance' ? 'selected' : '' }}>Insurance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Items table --}}
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="billingItemsTable">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th width="90">Qty</th>
                                            <th width="150">Unit Price</th>
                                            <th width="150">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach($items ?? [] as $index => $item)
                                            @php
                                                $qty = $item['quantity'] ?? 1;
                                                $price = $item['unit_price'] ?? 0;
                                                $subtotal = $qty * $price;
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item['description'] ?? '' }}" readonly>
                                                    <input type="hidden" name="items[{{ $index }}][hospital_service_id]" value="{{ $item['hospital_service_id'] ?? '' }}">
                                                </td>
                                                <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control qty" value="{{ $qty }}"></td>
                                                <td><input type="number" name="items[{{ $index }}][unit_price]" class="form-control price" step="0.01" value="{{ number_format($price, 2) }}"></td>
                                                <td class="subtotal">{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>KES {{ number_format($total, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <input type="hidden" name="amount" value="{{ $total }}">

                            <div class="row clearfix mt-3">
                                <div class="col-sm-12 text-right">
                                    <a href="{{ route('billings') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-round">Save Billing</button>
                                </div>
                            </div>
                        </form>
                    </div> {{-- body --}}
                </div> {{-- card --}}
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update subtotal & total dynamically
    const table = document.getElementById('billingItemsTable');
    const amountInput = document.querySelector('input[name="amount"]');

    function updateTotals() {
        let total = 0;
        table.querySelectorAll('tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const subtotal = qty * price;
            row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
            total += subtotal;
        });
        table.querySelector('tfoot strong').textContent = 'KES ' + total.toFixed(2);
        amountInput.value = total.toFixed(2);
    }

    table.addEventListener('input', updateTotals);
});
</script>
@endsection
