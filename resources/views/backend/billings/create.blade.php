@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Create Billing
                    <small>Welcome to Hospital System</small>
                </h2>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row clearfix justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card">
                    <div class="header bg-primary text-white">
                        <h5 class="mb-0"><i class="zmdi zmdi-money"></i> New Billing Record</h5>
                    </div>

                    <div class="body">
                        <form action="{{ route('billings.store') }}" method="POST">
                            @csrf

                            {{-- Patient --}}
                            <div class="form-group">
                                <label>Patient</label>
                                <select name="patient_id" class="form-control" {{ isset($billableItem) ? 'readonly disabled' : '' }} required>
                                    @if(isset($billableItem) && isset($billableItem->patient))
                                        <option value="{{ $billableItem->patient->id }}" selected>
                                            {{ $billableItem->patient->fname }} {{ $billableItem->patient->lname }}
                                        </option>
                                    @else
                                        <option value="" disabled selected>-- Select Patient --</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->fname }} {{ $patient->lname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Billable Info --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Billable Type</label>
                                        <input type="text" name="billable_type"
                                            class="form-control"
                                            value="{{ $billableType ?? '' }}"
                                            readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Billable ID</label>
                                        <input type="text" name="billable_id"
                                            class="form-control"
                                            value="{{ $billableId ?? '' }}"
                                            readonly required>
                                    </div>
                                </div>
                            </div>

                            {{-- Amount --}}
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" value="{{ $amount ?? '' }}" required {{ isset($amount) ? 'readonly' : '' }}>
                            </div>

                            {{-- Payment Method --}}
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="insurance">Insurance</option>
                                </select>
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="unpaid">Unpaid</option>
                                    <option value="paid">Paid</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="mt-4 text-right">
                                <button type="submit" class="btn btn-primary btn-round">Save</button>
                                <a href="{{ route('billings') }}" class="btn btn-default btn-round btn-simple">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
