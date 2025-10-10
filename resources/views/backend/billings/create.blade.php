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
                        <form id="billingForm" action="{{ route('billings.store') }}" method="POST">
                            @csrf

                            {{-- Patient + Payment + Fetch --}}
                            <div class="row clearfix mb-3">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="patient_id">Patient</label>
                                        <select name="patient_id" id="patientSelect" class="form-control show-tick" required>
                                            <option value="" selected disabled>-- Select Patient --</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}">
                                                    {{ $patient->fname }} {{ $patient->lname }}{{ $patient->email ? ' - '.$patient->email : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="payment_method">Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="form-control show-tick">
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="mpesa">M-Pesa</option>
                                            <option value="insurance">Insurance</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3 d-flex align-items-end">
                                    <button type="button" id="fetchServicesBtn" class="btn btn-info btn-block">
                                        <i class="zmdi zmdi-refresh-sync"></i> Fetch Services
                                    </button>
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
                                            <th width="80">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsBody">
                                        {{-- If you want a blank row by default uncomment below:
                                        <tr>
                                            <td><input type="text" name="items[0][description]" class="form-control" required></td>
                                            <td><input type="number" name="items[0][quantity]" class="form-control qty" min="1" value="1"></td>
                                            <td><input type="number" name="items[0][unit_price]" class="form-control price" min="0" step="0.01" value="0.00"></td>
                                            <td class="subtotal">0.00</td>
                                            <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="zmdi zmdi-delete"></i></button></td>
                                        </tr>
                                        --}}
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td class="text-right"><strong>Total:</strong></td>
                                            <td colspan="2"><strong>KES <span id="totalAmount">0.00</span></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Hidden total amount for server & submit --}}
                            <input type="hidden" name="amount" id="amountInput" value="0.00">

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
document.addEventListener('DOMContentLoaded', function () {
    // Base URL for AJAX fetch - admin prefix used (adjust if your route is different)
    const baseFetchUrl = "{{ url('admin/billings/fetch-patient-services') }}";
    const patientSelect = document.getElementById('patientSelect');
    const fetchBtn = document.getElementById('fetchServicesBtn');
    const itemsBody = document.getElementById('itemsBody');
    const totalAmountEl = document.getElementById('totalAmount');
    const amountInput = document.getElementById('amountInput');

    let itemIndex = 0;

    // Helper: add an item row
    function addItemRow({ description = '', quantity = 1, unit_price = 0.00, readonlyDescription = false, hospital_service_id = null } = {}) {
        const idx = itemIndex++;
        const tr = document.createElement('tr');

        tr.innerHTML = `
            <td>
                <input type="text" name="items[${idx}][description]" class="form-control" value="${escapeHtml(description)}" ${readonlyDescription ? 'readonly' : ''} required>
                ${hospital_service_id ? `<input type="hidden" name="items[${idx}][hospital_service_id]" value="${hospital_service_id}">` : ''}
            </td>
            <td><input type="number" name="items[${idx}][quantity]" class="form-control qty" min="1" value="${parseInt(quantity, 10)}"></td>
            <td><input type="number" name="items[${idx}][unit_price]" class="form-control price" min="0" step="0.01" value="${parseFloat(unit_price).toFixed(2)}"></td>
            <td class="subtotal">${(parseInt(quantity,10) * parseFloat(unit_price)).toFixed(2)}</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item"><i class="zmdi zmdi-delete"></i></button></td>
        `;
        itemsBody.appendChild(tr);
        updateTotals();
    }

    // Escape helper to avoid XSS when inserting API text
    function escapeHtml(text) {
        if (text == null) return '';
        return text
            .toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Remove item
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.remove-item');
        if (!btn) return;
        btn.closest('tr').remove();
        updateTotals();
    });

    // Update totals when qty or price change
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
            updateTotals();
        }
    });

    function updateTotals() {
        let total = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qtyEl = row.querySelector('.qty');
            const priceEl = row.querySelector('.price');
            const subtotalEl = row.querySelector('.subtotal');

            const qty = qtyEl ? parseFloat(qtyEl.value || 0) : 0;
            const price = priceEl ? parseFloat(priceEl.value || 0) : 0;
            const subtotal = qty * price;

            if (subtotalEl) subtotalEl.textContent = subtotal.toFixed(2);
            total += subtotal;
        });

        totalAmountEl.textContent = total.toFixed(2);
        amountInput.value = total.toFixed(2);
    }

    // Fetch services button
    fetchBtn.addEventListener('click', function () {
        const patientId = patientSelect.value;
        if (!patientId) {
            alert('Please select a patient first.');
            return;
        }

        const url = `${baseFetchUrl}/${patientId}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(json => {
            if (!json.success) {
                alert(json.message || 'No services found for this patient.');
                return;
            }

            // Clear existing items
            itemsBody.innerHTML = '';
            itemIndex = 0;

            // Populate
            (json.items || []).forEach(it => {
                // 'it' should contain description, quantity, unit_price, hospital_service_id (optional)
                addItemRow({
                    description: it.description,
                    quantity: it.quantity ?? 1,
                    unit_price: it.unit_price ?? 0,
                    readonlyDescription: true,
                    hospital_service_id: it.hospital_service_id ?? null
                });
            });

            // If server returned empty items, optionally show a blank row
            if (!json.items || json.items.length === 0) {
                addItemRow({ description: '', quantity: 1, unit_price: 0, readonlyDescription: false });
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error fetching services. Check console for details.');
        });
    });

    // Optionally add an empty row by default
    addItemRow({ description: '', quantity: 1, unit_price: 0, readonlyDescription: false });
});
</script>
@endsection
