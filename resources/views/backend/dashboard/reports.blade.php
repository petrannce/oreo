@extends('layouts.backend.header')

@section('content')
<section class="content">
    <div class="block-header">
        <h2>Reports Dashboard <small class="text-muted">Analyse data across modules</small></h2>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="header">
                <h2><strong>Dynamic Reports</strong></h2>
            </div>
            <div class="body">

                <!-- Filters Row -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Report Type</label>
                        <select id="reportType" class="form-control">
                            <option value="billings">Billings</option>
                            <option value="appointments">Appointments</option>
                            <option value="patients">Patients</option>
                            <option value="lab_tests">Lab Tests</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Mode</label>
                        <select id="reportMode" class="form-control">
                            <option value="summarised">Summarised</option>
                            <option value="detailed">Detailed</option>
                            <option value="parameterised">Parameterised</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>From Date</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>To Date</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                </div>

                <!-- Parameter Dropdowns -->
                <div class="row mb-3">
                    <div class="col-md-3" id="paramFieldContainer" style="display:none;">
                        <label>Field</label>
                        <select id="paramField" class="form-control"></select>
                    </div>
                    <div class="col-md-3" id="paramValueContainer" style="display:none;">
                        <label>Value</label>
                        <select id="paramValue" class="form-control"></select>
                    </div>
                </div>

                <!-- Export Buttons -->
                <div class="mb-3 text-right">
                    <button class="btn btn-success" id="exportExcel"><i class="zmdi zmdi-file-text"></i> Export Excel</button>
                    <button class="btn btn-danger" id="exportPDF"><i class="zmdi zmdi-file"></i> Export PDF</button>
                </div>

                <!-- KPI Cards -->
                <div class="row" id="cardsRow"></div>

                <!-- Data Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="reportTable">
                        <thead>
                            <tr id="tableHead"></tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSel = document.getElementById('reportType');
    const modeSel = document.getElementById('reportMode');
    const from = document.getElementById('fromDate');
    const to = document.getElementById('toDate');
    const paramField = document.getElementById('paramField');
    const paramValue = document.getElementById('paramValue');
    const paramFieldContainer = document.getElementById('paramFieldContainer');
    const paramValueContainer = document.getElementById('paramValueContainer');

    function fetchReport() {
        const payload = {
            type: typeSel.value,
            mode: modeSel.value,
            from_date: from.value,
            to_date: to.value,
            field: paramField.value || null,
            value: paramValue.value || null,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("reports.filterData") }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            renderCards(res.cards);
            renderTable(res.table);

            // Parameter dropdowns
            if (modeSel.value === 'parameterised' && res.fields && res.fields.length) {
                paramFieldContainer.style.display = 'block';
                paramField.innerHTML = '<option value="">Select Field</option>';
                res.fields.forEach(f => paramField.innerHTML += `<option value="${f}">${f}</option>`);
            } else {
                paramFieldContainer.style.display = 'none';
                paramValueContainer.style.display = 'none';
            }
        })
        .catch(err => console.error(err));
    }

    function renderCards(cards) {
        const cardsRow = document.getElementById('cardsRow');
        cardsRow.innerHTML = '';
        cards.forEach(c => {
            cardsRow.innerHTML += `
                <div class="col-md-3 mb-3">
                    <div class="card text-center p-3" style="border-top:4px solid ${c.color}">
                        <i class="zmdi ${c.icon} zmdi-hc-2x" style="color:${c.color}"></i>
                        <h6 class="mt-2">${c.label}</h6>
                        <h4><strong>${c.value}</strong></h4>
                    </div>
                </div>`;
        });
    }

    function renderTable(rows) {
        const thead = document.getElementById('tableHead');
        const tbody = document.getElementById('tableBody');
        thead.innerHTML = tbody.innerHTML = '';

        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center">No data available</td></tr>';
            return;
        }

        const headers = Object.keys(rows[0]);
        headers.forEach(h => thead.innerHTML += `<th>${h}</th>`);
        rows.forEach(r => {
            tbody.innerHTML += `<tr>${headers.map(h => `<td>${r[h] ?? '-'}</td>`).join('')}</tr>`;
        });
    }

    // Listeners
    [typeSel, modeSel, from, to].forEach(e => e.addEventListener('change', fetchReport));
    paramField.addEventListener('change', fetchReport);
    paramValue.addEventListener('change', fetchReport);

    // Export buttons (stub example)
    document.getElementById('exportExcel').onclick = () => alert('Excel export coming soon');
    document.getElementById('exportPDF').onclick = () => alert('PDF export coming soon');

    // Initial load
    fetchReport();
});
</script>
@endsection
