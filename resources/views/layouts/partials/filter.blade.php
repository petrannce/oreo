<div class="row mb-4">
    <div class="col-md-12">
        <form action="{{ $filterRoute }}" method="GET" class="form-inline align-items-end">

            <input type="hidden" name="type" value="{{ $type ?? '' }}">

            {{-- Date Range --}}
            <div class="form-group mr-3">
                <label for="from_date" class="mr-2">From</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}"
                       class="form-control">
            </div>

            <div class="form-group mr-3">
                <label for="to_date" class="mr-2">To</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}"
                       class="form-control">
            </div>

            {{-- Dynamic Extra Filters --}}
            @if(!empty($extraFilters))
                @foreach($extraFilters as $filter)
                    {!! $filter !!}
                @endforeach
            @endif

            {{-- Submit & Reset --}}
            <button type="submit" class="btn btn-primary mr-2">
                <i class="zmdi zmdi-filter-list"></i> Apply Filters
            </button>

            <a href="{{ $filterRoute }}" class="btn btn-secondary mr-3">
                <i class="zmdi zmdi-refresh"></i> Reset
            </a>

            {{-- Export Dropdown --}}
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="zmdi zmdi-download"></i> Export Report
                </button>

                <div class="dropdown-menu" aria-labelledby="exportDropdown">
                    <a class="dropdown-item"
                       href="{{ $reportRoute }}?{{ http_build_query(array_merge(request()->all(), ['type' => $type, 'format' => 'pdf'])) }}"
                       target="_blank">
                        <i class="zmdi zmdi-file-text"></i> Export as PDF
                    </a>

                    <a class="dropdown-item"
                       href="{{ $reportRoute }}?{{ http_build_query(array_merge(request()->all(), ['type' => $type, 'format' => 'csv'])) }}">
                        <i class="zmdi zmdi-file"></i> Export as CSV
                    </a>

                    <a class="dropdown-item"
                       href="{{ $reportRoute }}?{{ http_build_query(array_merge(request()->all(), ['type' => $type, 'format' => 'excel'])) }}">
                        <i class="zmdi zmdi-grid"></i> Export as Excel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
