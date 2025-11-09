@extends('layouts.backend.header')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">

    <style>
        .report-card {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(14, 30, 37, 0.06);
            padding: 18px;
            background: #fff;
        }

        .report-card .label {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .report-card .value {
            font-size: 1.35rem;
            font-weight: 700;
            margin-top: 6px;
        }

        .report-top {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .param-row {
            margin-top: 12px;
        }

        .small-muted {
            font-size: .85rem;
            color: #6b7280;
        }

        .export-btns a {
            margin-left: 8px;
        }

        .card-icon {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 8px;
        }

        .sticky-filters {
            position: sticky;
            top: 16px;
            z-index: 5;
        }

        .chart-card {
            min-height: 300px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .report-card .value {
                font-size: 1.1rem;
            }
        }
    </style>

    <section class="content">
        <div class="block-header mb-3">
            <h2>Reports Dashboard <small class="text-muted">Analyze data across modules</small></h2>
        </div>

        <div class="container-fluid">

            {{-- Filters --}}
            <div class="card mb-3 p-3 report-card sticky-filters">
                <form method="GET" action="{{ route('dashboard.reports') }}" id="reportsForm"
                    class="row g-3 align-items-end">
                    @csrf
                    {{-- Report Type --}}
                    <div class="col-md-3">
                        <label class="form-label">Report Type</label>
                        <select name="type" id="reportType" class="form-control">
                            @php
                                $types = [
                                    'billings' => 'Billings',
                                    'appointments' => 'Appointments',
                                    'patients' => 'Patients',
                                    'lab_tests' => 'Lab Tests',
                                ];
                                $selType = request('type', $defaultType ?? 'billings');
                            @endphp
                            @foreach($types as $k => $label)
                                <option value="{{ $k }}" {{ $selType === $k ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Mode --}}
                    <div class="col-md-3">
                        <label class="form-label">Mode</label>
                        @php $selMode = request('mode', $defaultMode ?? 'summarised'); @endphp
                        <select name="mode" id="reportMode" class="form-control">
                            <option value="summarised" {{ $selMode === 'summarised' ? 'selected' : '' }}>Summarised</option>
                            <option value="detailed" {{ $selMode === 'detailed' ? 'selected' : '' }}>Detailed</option>
                            <option value="parameterised" {{ $selMode === 'parameterised' ? 'selected' : '' }}>Parameterised
                            </option>
                        </select>
                    </div>

                    {{-- Dates --}}
                    <div class="col-md-2">
                        <label class="form-label">From</label>
                        <input type="date" name="from_date" id="fromDate" class="form-control"
                            value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To</label>
                        <input type="date" name="to_date" id="toDate" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    {{-- Apply / Reset --}}
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary w-100 mb-1"><i class="zmdi zmdi-refresh"></i>
                            Apply</button>
                        <button type="button" onclick="resetFilters()"
                            class="btn btn-outline-secondary w-100">Reset</button>
                    </div>

                    {{-- Parameterised Row --}}
                    <div class="col-12 param-row" id="paramRow" style="display:none;">
                        <div class="row g-3">
                            <div class="col-md-4" id="paramFieldContainer">
                                <label class="form-label">Parameter Field</label>
                                <select name="field" id="paramField" class="form-control">
                                    <option value="">-- choose field --</option>
                                    @foreach($data['fields'] ?? [] as $f)
                                        <option value="{{ $f }}" {{ request('field') === $f ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $f)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="small-muted mt-1">Choose a field to group by.</div>
                            </div>
                            <div class="col-md-4" id="paramValueContainer" style="display:none;">
                                <label class="form-label">Value (optional)</label>
                                <select name="value" id="paramValue" class="form-control">
                                    <option value="">-- choose value --</option>
                                    @php
                                        $selectedField = request('field');
                                        $values = [];
                                        if ($selectedField && !empty($data['table'])) {
                                            foreach ($data['table'] as $row) {
                                                if (isset($row[$selectedField]))
                                                    $values[] = (string) $row[$selectedField];
                                            }
                                            $values = array_unique($values);
                                        }
                                    @endphp
                                    @foreach($values as $v)
                                        <option value="{{ $v }}" {{ request('value') == $v ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                                <div class="small-muted mt-1">Optional: narrow the parameterised result.</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Export Buttons --}}
            <div class="mb-3 d-flex justify-content-end export-btns">
                @php
                    $qs = request()->except(['_token']);
                    $queryString = count($qs) ? ('?' . http_build_query($qs)) : '';
                @endphp
                <a href="{{ route('reports.generate') }}{{ $queryString }}&format=pdf" class="btn btn-danger"><i
                        class="zmdi zmdi-file"></i> PDF</a>
                <a href="{{ route('reports.generate') }}{{ $queryString }}&format=excel" class="btn btn-success"><i
                        class="zmdi zmdi-file-text"></i> Excel</a>
                <a href="{{ route('reports.generate') }}{{ $queryString }}&format=csv" class="btn btn-info"><i
                        class="zmdi zmdi-download"></i> CSV</a>
            </div>

            {{-- KPI Cards --}}
            <div class="row mb-3" id="cardsRow">
                @forelse($data['cards'] ?? [] as $card)
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="report-card text-center">
                            <div>
                                <i class="zmdi {{ $card['icon'] ?? 'zmdi-chart' }} card-icon"
                                    style="color: {{ $card['color'] ?? '#007bff' }}"></i>
                            </div>
                            <div class="label mt-2">{{ ucwords($card['label'] ?? 'Metric') }}</div>
                            <div class="value">{{ $card['value'] ?? '-' }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><em>No KPI cards to display.</em></div>
                @endforelse
            </div>

            {{-- Charts --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="card mb-3 p-3 report-card chart-card">
                        <h5>Trend</h5>
                        <div id="trendChart" style="height:340px;"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3 p-3 report-card chart-card">
                        <h5>Distribution</h5>
                        <div id="pieChart" style="height:340px;"></div>
                    </div>
                </div>
            </div>

            {{-- Results Table --}}
            <div class="card p-3 report-card">
                <h5 class="mb-3">Results</h5>
                <div class="table-responsive">
                    <table id="reportTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                @if(!empty($data['table']))
                                    @foreach(array_keys($data['table'][0]) as $h)<th>{{ ucwords(str_replace('_', ' ', $h)) }}
                                        </th>
                                    @endforeach
                                @else
                                    <th>No data</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data['table'] ?? [] as $row)
                                <tr>
                                    @foreach($row as $val)<td>{{ $val }}</td>@endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="20">No data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Flatpickr
            flatpickr("#fromDate");
            flatpickr("#toDate");

            // Show parameter row if mode=parameterised
            let paramRow = document.getElementById('paramRow');
            if ('{{ $selMode }}' === 'parameterised') {
                paramRow.style.display = 'block';
            }

            let paramField = document.getElementById('paramField');
            let paramValue = document.getElementById('paramValue');
            if (paramField && paramValue) {
                paramField.addEventListener('change', function () {
                    if (this.value) {
                        document.getElementById('paramValueContainer').style.display = 'block';
                    } else {
                        document.getElementById('paramValueContainer').style.display = 'none';
                    }
                });
            }

            window.resetFilters = function () {
    // Get the current report type value
    const reportType = document.getElementById('reportType').value;

    // Reset the form
    document.getElementById('reportsForm').reset();

    // Restore the report type
    document.getElementById('reportType').value = reportType;

    // Hide parameter rows
    document.getElementById('paramRow').style.display = 'none';
    document.getElementById('paramValueContainer').style.display = 'none';
};


            // ApexCharts Trend (line chart)
            let trendData = @json($data['chart'] ?? []);

            if (!trendData.length) {
                document.querySelector('#trendChart').innerHTML = '<em>No trend data.</em>';
            } else {
                let trendOptions = {
                    chart: { type: 'line', height: 340, toolbar: { show: true } },
                    series: [{ name: 'Value', data: trendData.map(d => d.total) }],
                    xaxis: { categories: trendData.map(d => d.label || d.date || '') },
                    stroke: { curve: 'smooth' },
                    markers: { size: 4 },
                    tooltip: { shared: true },
                };
                let trendChart = new ApexCharts(document.querySelector("#trendChart"), trendOptions);
                trendChart.render();
            }

            // ApexCharts Pie
            let pieData = @json($data['pieChart'] ?? []);

            if (!pieData.length) {
                document.querySelector('#pieChart').innerHTML = '<em>No distribution data.</em>';
            } else {
                let pieOptions = {
                    chart: { type: 'pie', height: 340 },
                    series: pieData.map(d => d.value ?? 0),
                    labels: pieData.map(d => d.label ?? '—'),
                    colors: pieData.map(d => d.color ?? '#007bff'),
                    legend: { position: 'bottom' },
                    tooltip: {
                        y: {
                            formatter: val => `${val} (${Math.round((val / pieData.reduce((sum, i) => sum + i.value, 0)) * 100)}%)`
                        }
                    }
                };
                let pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
                pieChart.render();
            }

        });

        // Dynamic column loading for Parameterised mode
        const reportTypeSelect = document.getElementById('reportType');
        const reportModeSelect = document.getElementById('reportMode');
        const paramRow = document.getElementById('paramRow');
        const paramField = document.getElementById('paramField');
        const paramValueContainer = document.getElementById('paramValueContainer');

        // Show/hide parameter row based on mode
        reportModeSelect.addEventListener('change', function () {
            if (this.value === 'parameterised') {
                paramRow.style.display = 'block';
            } else {
                paramRow.style.display = 'none';
                paramField.innerHTML = '<option value="">-- choose field --</option>';
                document.getElementById('paramValue').innerHTML = '<option value="">-- choose value --</option>';
            }
        });

        document.getElementById('reportType').addEventListener('change', function () {
            // Create a new URL object for the current page
            const url = new URL(window.location);
            // Update the 'type' query parameter
            url.searchParams.set('type', this.value);
            // Update the 'mode' query parameter
            url.searchParams.set('mode', document.getElementById('reportMode').value);
            // Reload the page with the new type
            window.location.href = url.toString();
        });

        $('#paramField').on('change', function () {
            const type = $('#reportType').val();
            const field = $(this).val();

            if (!field) {
                $('#paramValue').html('<option value="">Select value...</option>');
                return;
            }

            fetch(`{{ route('reports.fieldValues') }}?type=${type}&field=${field}`)
                .then(res => res.json())
                .then(res => {
                    const values = res.values || [];
                    const options = values.map(v => `<option value="${v}">${v}</option>`).join('');
                    paramValue.innerHTML = '<option value="">Select value...</option>' + options;
                })
                .catch(() => {
                    paramValue.innerHTML = '<option value="">Error loading values</option>';
                });

        });
    </script>


@endsection