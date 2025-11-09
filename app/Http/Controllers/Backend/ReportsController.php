<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Billing;
use App\Models\Appointment;
use App\Models\LabTest;
use App\Models\Patient;

class ReportsController extends Controller
{
    private array $allowedFields = [
        'billings' => ['status', 'payment_method'],
        'patients' => ['gender', 'country'],
        'appointments' => ['status', 'doctor_id'],
        'lab_tests' => ['status']
    ];

    public function index(Request $request)
    {
        $defaultType = 'billings';
        $defaultMode = 'summarised';

        $payload = [
            'type' => $request->get('type', $defaultType),
            'mode' => $request->get('mode', $defaultMode),
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'field' => $request->get('field'),
            'value' => $request->get('value'),
        ];

        $data = $this->buildReportResponseArray(new Request($payload));
        $data['pieChart'] = $this->buildPieChartData($data);

        return view('backend.dashboard.reports', [
            'defaultType' => $defaultType,
            'defaultMode' => $defaultMode,
            'selMode' => $payload['mode'],
            'data' => $data,
            'fields' => $data['fields'] ?? [],
        ]);
    }

    public function filterData(Request $request)
    {
        $data = $this->buildReportResponseArray($request);
        $data['pieChart'] = $this->buildPieChartData($data);
        return response()->json($data);
    }

    private function buildReportResponseArray(Request $request): array
    {
        $type = $request->get('type', 'billings');

        $result = match ($type) {
            'billings' => $this->billingReportArray($request),
            'patients' => $this->patientReportArray($request),
            'appointments' => $this->appointmentReportArray($request),
            'lab_tests' => $this->labTestReportArray($request),
            default => [],
        };

        return [
            'cards' => $result['cards'] ?? [],
            'table' => $result['table'] ?? [],
            'fields' => $result['fields'] ?? [],
            'chart' => $result['chart'] ?? [],
            'pieChart' => $result['pieChart'] ?? [],
        ];
    }


    private function buildPieChartData(array $data): array
    {
        $pieChart = [];

        $cards = $data['cards'] ?? [];
        if (empty($cards)) {
            return [];
        }

        // labels that are pure totals and should be excluded (exact match, case-insensitive)
        $excludedExact = [
            'total patients',
            'total bills',
            'total lab tests',
            'total appointments',
            'total amount',
            'total amount (kes)',
            'detailed bills',
            'detailed patients',
        ];

        foreach ($cards as $card) {
            // pick the numeric candidate
            $rawValue = $card['numeric_value']
                ?? $card['value']
                ?? $card['count']
                ?? null;

            // sanitize string values (e.g., "5 (KES 1,500.00)" or "12 patients")
            if (is_string($rawValue)) {
                // strip any non-digit/decimal characters to try get a numeric part
                $clean = preg_replace('/[^\d.]+/', '', $rawValue);
                $value = $clean === '' ? 0 : (float) $clean;
            } else {
                $value = is_null($rawValue) ? 0 : (float) $rawValue;
            }

            // normalized label for checks
            $label = trim(strtolower((string) ($card['label'] ?? '')));

            // skip exact totals (but do NOT skip labels that merely contain "total" with extra context,
            // e.g. "Total Male Patients" should be included)
            if (in_array($label, $excludedExact, true)) {
                continue;
            }

            // skip zero or negative values
            if ($value <= 0) {
                continue;
            }

            $pieChart[] = [
                'label' => $card['label'] ?? 'Metric',
                'value' => $value,
                'color' => $card['color'] ?? '#007bff',
            ];
        }

        // Calculate percentages (useful for front-end display)
        $total = array_sum(array_column($pieChart, 'value'));
        if ($total > 0) {
            foreach ($pieChart as &$slice) {
                $slice['percentage'] = round(($slice['value'] / $total) * 100, 2);
            }
            unset($slice);
        }

        return array_values($pieChart);
    }

    private function applyDateRange($query, string $column, ?string $from, ?string $to): void
    {
        if ($from && $to)
            $query->whereBetween($column, [$from, $to]);
        elseif ($from)
            $query->whereDate($column, '>=', $from);
        elseif ($to)
            $query->whereDate($column, '<=', $to);
    }

    private function getTableColumns(string $type): array
    {
        // Map report type to table name
        $map = [
            'billings' => 'billings',
            'appointments' => 'appointments',
            'lab_tests' => 'lab_tests',
            'patients' => 'patients',
        ];

        $table = $map[$type] ?? null;
        if (!$table) {
            return [];
        }

        // Safely fetch column list
        try {
            return Schema::getColumnListing($table);
        } catch (\Exception $e) {
            \Log::error("Column fetch failed for {$table}: " . $e->getMessage());
            return [];
        }
    }

    public function getFieldValues(Request $request)
    {
        $type = $request->get('type');
        $field = $request->get('field');

        // Validate type and field
        if (!isset($this->allowedFields[$type]) || !in_array($field, $this->allowedFields[$type])) {
            return response()->json(['values' => []]);
        }

        $map = [
            'billings' => Billing::query(),
            'appointments' => Appointment::query(),
            'patients' => Patient::query(),
            'lab_tests' => LabTest::query(),
        ];

        try {
            $values = $map[$type]
                ->select($field)
                ->distinct()
                ->whereNotNull($field)
                ->limit(100)
                ->pluck($field)
                ->map(fn($v) => is_string($v) ? trim($v) : $v)
                ->values()
                ->toArray();

            return response()->json(['values' => $values]);
        } catch (\Exception $e) {
            \Log::error("Value fetch failed for {$type}.{$field}: " . $e->getMessage());
            return response()->json(['values' => []]);
        }
    }


    // ---------------- BILLINGS ----------------
    private function billingReportArray(Request $r): array
    {
        $mode = $r->get('mode', 'summarised');
        $from = $r->get('from_date');
        $to = $r->get('to_date');
        $field = $r->get('field');
        $value = $r->get('value');

        $query = Billing::with('patient');
        $this->applyDateRange($query, 'created_at', $from, $to);

        if ($field && $value && in_array($field, $this->getTableColumns('billings'))) {
            $query->where($field, $value);
        }

        if ($mode === 'parameterised') {
            return $this->parameterisedArray($query, 'billings', $field, 'amount');
        }

        return match ($mode) {
            'summarised' => $this->billingSummarisedArray($query),
            'detailed' => $this->billingDetailedArray($query),
            default => $this->billingSummarisedArray($query)
        };
    }

    private function billingSummarisedArray($query): array
    {
        $totals = (clone $query)
            ->selectRaw('COUNT(*) as total_bills, SUM(amount) as total_amount')
            ->first();

        $total = (int) $totals->total_bills ?? 0;
        $totalAmount = (float) ($totals->total_amount ?? 0);

        $statusCounts = (clone $query)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $paid = $statusCounts['paid'] ?? 0;
        $unpaid = $statusCounts['unpaid'] ?? 0;
        $otherStatuses = collect($statusCounts)
            ->except(['paid', 'unpaid'])
            ->map(fn($count, $status) => [
                'label' => ucfirst($status),
                'value' => $count,
                'numeric_value' => $count,
                'color' => '#17a2b8',
                'icon' => 'zmdi-label',
            ])->values()->toArray();

        $cards = [
            ['label' => 'Total Bills', 'value' => $total, 'numeric_value' => $total, 'color' => '#007bff', 'icon' => 'zmdi-receipt'],
            ['label' => 'Total Amount (KES)', 'value' => number_format($totalAmount, 2), 'numeric_value' => $totalAmount, 'color' => '#6f42c1', 'icon' => 'zmdi-money'],
            ['label' => 'Paid Bills', 'value' => $paid, 'numeric_value' => $paid, 'color' => '#28a745', 'icon' => 'zmdi-check-circle'],
            ['label' => 'Unpaid Bills', 'value' => $unpaid, 'numeric_value' => $unpaid, 'color' => '#ffc107', 'icon' => 'zmdi-time'],
            ...$otherStatuses,
        ];

        $rows = $query->latest()->limit(20)->get();
        $table = $rows->map(fn($b) => [
            'ID' => $b->id,
            'Patient' => $b->patient?->fname . ' ' . $b->patient?->lname,
            'Amount' => number_format($b->amount, 2),
            'Payment Method' => $b->payment_method ?? '-',
            'Status' => ucfirst($b->status),
            'Date' => $b->created_at->format('Y-m-d'),
        ])->toArray();

        $chart = $query
            ->reorder()
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (float) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['payment_method', 'status'], 'chart' => $chart];
    }

    private function billingDetailedArray($query): array
    {
        $rows = $query->latest()->limit(100)->get();
        $table = $rows->map(fn($b) => [
            'ID' => $b->id,
            'Patient' => $b->patient?->fname . ' ' . $b->patient?->lname,
            'Billable Type' => class_basename($b->billable_type),
            'Billable ID' => $b->billable_id,
            'Amount' => number_format($b->amount, 2),
            'Payment Method' => $b->payment_method ?? '-',
            'Status' => ucfirst($b->status),
            'Created' => $b->created_at->format('Y-m-d H:i'),
        ])->toArray();

        $cards = [
            ['label' => 'Detailed Bills', 'value' => (int) $query->count(), 'numeric_value' => (int) $query->count(), 'color' => '#17a2b8', 'icon' => 'zmdi-assignment'],
            ['label' => 'Total Amount', 'value' => number_format($query->sum('amount'), 2), 'numeric_value' => (float) $query->sum('amount'), 'color' => '#6610f2', 'icon' => 'zmdi-balance-wallet'],
            ['label' => 'Paid Bills', 'value' => (int) (clone $query)->where('status', 'paid')->count(), 'numeric_value' => (int) (clone $query)->where('status', 'paid')->count(), 'color' => '#28a745', 'icon' => 'zmdi-check-circle'],
            ['label' => 'Unpaid Bills', 'value' => (int) (clone $query)->where('status', 'unpaid')->count(), 'numeric_value' => (int) (clone $query)->where('status', 'unpaid')->count(), 'color' => '#ffc107', 'icon' => 'zmdi-time'],
        ];

        $chart = $query
            ->reorder()
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (float) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['payment_method', 'status'], 'chart' => $chart];
    }

    // ---------------- PARAMETERISED ARRAY GENERIC ----------------
    private function parameterisedArray($query, string $table, ?string $field, ?string $sumField = null): array
    {
        $columns = $this->getTableColumns($table);

        if (!$field || !in_array($field, $columns)) {
            \Log::info("parameterisedArray called for table {$table} with field '{$field}' and sumField '{$sumField}'");
            return ['cards' => [], 'table' => [], 'fields' => [], 'chart' => []];
        }

        $selects = [$field, DB::raw('COUNT(*) as total')];
        if ($sumField && in_array($sumField, $this->getTableColumns($table))) {
            $selects[] = DB::raw("SUM($sumField) as total_amount");
        }

        $queryBuilder = (clone $query)
            ->select($selects)
            ->groupBy($field)
            ->orderByDesc(DB::raw($sumField ? "SUM($sumField)" : "COUNT(*)"))
            ->limit(200);

        \Log::info('Parameterised query SQL:', [
            'sql' => $queryBuilder->toSql(),
            'bindings' => $queryBuilder->getBindings(),
        ]);

        $groups = $queryBuilder->get();
        \Log::info('Raw data:', $groups->toArray());


        // Ensure numeric_value is explicitly numeric
        $cards = $groups->map(fn($g) => [
            'label' => ucwords(str_replace('_', ' ', $g->{$field} ?? '—')),
            'value' => $sumField ? ($g->total . ' (KES ' . number_format($g->total_amount, 2) . ')') : $g->total,
            'numeric_value' => $sumField ? (float) $g->total_amount : (int) $g->total,
            'color' => '#007bff',
            'icon' => 'zmdi-chart',
        ])->toArray();

        $tableData = $groups->map(fn($g) => [
            ucwords(str_replace('_', ' ', $field)) => $g->{$field} ?? '—',
            'Count' => (int) $g->total,
            'Total (KES)' => $sumField ? number_format($g->total_amount, 2) : null,
        ])->toArray();

        $chart = $groups->map(fn($g) => [
            'label' => (string) ($g->{$field} ?? '—'),
            'total' => $sumField ? (float) $g->total_amount : (int) $g->total
        ])->toArray();

        return ['cards' => $cards, 'table' => $tableData, 'fields' => [$field], 'chart' => $chart];
    }

    // ---------------- PATIENTS ----------------
    private function patientReportArray(Request $r): array
    {
        $mode = $r->get('mode', 'summarised');
        $from = $r->get('from_date');
        $to = $r->get('to_date');
        $field = $r->get('field');
        $value = $r->get('value');

        $q = Patient::query();
        $this->applyDateRange($q, 'created_at', $from, $to);

        if ($field && $value && in_array($field, $this->getTableColumns('patients'))) {
            $q->where($field, $value);
        }

        if ($mode === 'parameterised') {
            return $this->parameterisedArray($q, 'patients', $field);
        }

        return match ($mode) {
            'summarised' => $this->patientSummarised($q),
            'detailed' => $this->patientDetailed($q),
            default => $this->patientSummarised($q)
        };
    }

    private function patientSummarised($q): array
    {
        $total = (int) $q->count();
        // Add gender breakdown so summary has distribution data
        $male = (int) (clone $q)->where('gender', 'male')->count();
        $female = (int) (clone $q)->where('gender', 'female')->count();
        $other = $total - $male - $female;
        if ($other < 0)
            $other = 0;

        $cards = [
            ['label' => 'Total Patients', 'value' => $total, 'numeric_value' => $total, 'color' => '#17a2b8', 'icon' => 'zmdi-accounts'],
            ['label' => 'Male', 'value' => $male, 'numeric_value' => $male, 'color' => '#17a2b8', 'icon' => 'zmdi-male'],
            ['label' => 'Female', 'value' => $female, 'numeric_value' => $female, 'color' => '#e83e8c', 'icon' => 'zmdi-female'],
        ];

        if ($other > 0) {
            $cards[] = ['label' => 'Other', 'value' => $other, 'numeric_value' => $other, 'color' => '#6c757d', 'icon' => 'zmdi-account'];
        }

        $rows = $q->latest()->limit(50)->get();
        $table = $rows->map(fn($p) => [
            'ID' => $p->id,
            'Name' => $p->fname . ' ' . $p->lname,
            'Email' => $p->email ?? '-',
            'Phone' => $p->phone_number ?? '-',
        ])->toArray();

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return [
        'cards' => $cards, 
        'table' => $table, 
        'fields' => $this->allowedFields['patients'],
        'chart' => $chart
    ];
    }

    private function patientDetailed($q): array
    {
        $rows = $q->latest()->limit(100)->get();
        $table = $rows->map(fn($p) => [
            'ID' => $p->id,
            'Name' => $p->fname . ' ' . $p->lname,
            'Email' => $p->email ?? '-',
            'Phone' => $p->phone_number ?? '-',
            'Gender' => $p->gender ?? '-',
            'DOB' => $p->dob ?? '-',
            'Country' => $p->country ?? '-',
            'Address' => $p->address ?? '-',
            'Registered' => $p->created_at->format('Y-m-d'),
        ])->toArray();

        $cards = [
            ['label' => 'Total Patients', 'value' => (int) $q->count(), 'numeric_value' => (int) $q->count(), 'color' => '#17a2b8', 'icon' => 'zmdi-accounts'],
            ['label' => 'Total Male Patients', 'value' => (int) (clone $q)->where('gender', 'male')->count(), 'numeric_value' => (int) (clone $q)->where('gender', 'male')->count(), 'color' => '#17a2b8', 'icon' => 'zmdi-male'],
            ['label' => 'Total Female Patients', 'value' => (int) (clone $q)->where('gender', 'female')->count(), 'numeric_value' => (int) (clone $q)->where('gender', 'female')->count(), 'color' => '#e83e8c', 'icon' => 'zmdi-female'],
        ];

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return [
            'cards' => $cards, 
            'table' => $table, 
            'fields' => $this->allowedFields['patients'],
            'chart' => $chart
        ];
    }

    // ---------------- APPOINTMENTS ----------------
    private function appointmentReportArray(Request $r): array
    {
        $mode = $r->get('mode', 'summarised');
        $from = $r->get('from_date');
        $to = $r->get('to_date');
        $field = $r->get('field');
        $value = $r->get('value');

        $q = Appointment::with('patient', 'doctor', 'bookedBy');
        $this->applyDateRange($q, 'date', $from, $to);

        if ($field && $value && in_array($field, $this->getTableColumns('appointments'))) {
            $q->where($field, $value);
        }

        if ($mode === 'parameterised') {
            $columns = $this->getTableColumns('appointments');
            if (!$field || !in_array($field, $columns)) {
                \Log::warning("Invalid field '{$field}' for appointments parameterised report.");
                return ['cards' => [], 'table' => [], 'fields' => [], 'chart' => []];
            }

            return $this->parameterisedArray($q, 'appointments', $field);
        }

        return match ($mode) {
            'summarised' => $this->appointmentSummarised($q),
            'detailed' => $this->appointmentDetailed($q),
            default => $this->appointmentSummarised($q)
        };
    }

    private function appointmentSummarised($q): array
    {
        $total = (int) $q->count();
        $cards = [['label' => 'Total Appointments', 'value' => $total, 'numeric_value' => $total, 'color' => '#007bff', 'icon' => 'zmdi-calendar']];

        // Dynamic status breakdown
        $statuses = $q->distinct()->pluck('status');
        foreach ($statuses as $status) {
            $count = (int) (clone $q)->where('status', $status)->count();
            $cards[] = [
                'label' => ucfirst($status),
                'value' => $count,
                'numeric_value' => $count,
                'color' => match ($status) {
                    'completed' => '#28a745',
                    'pending' => '#ffc107',
                    'cancelled' => '#dc3545',
                    default => '#6c757d'
                },
                'icon' => 'zmdi-check'
            ];
        }

        $rows = $q
            ->latest()
            ->limit(50)
            ->get();
        $table = $rows->map(fn($a) => [
            'ID' => $a->id,
            'Date' => $a->date,
            'Time' => $a->time,
            'Patient' => $a->patient?->fname . ' ' . $a->patient?->lname,
            'Doctor' => $a->doctor?->fname . ' ' . $a->doctor?->lname,
            'Status' => ucfirst($a->status)
        ])->toArray();

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(date) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(date)'))
            ->orderByDesc(DB::raw('DATE(date)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['doctor_id', 'status'], 'chart' => $chart];
    }

    private function appointmentDetailed($q): array
    {
        $rows = $q->latest()->limit(100)->get();
        $table = $rows->map(fn($a) => [
            'ID' => $a->id,
            'Date' => $a->date,
            'Time' => $a->time,
            'Patient' => $a->patient?->fname . ' ' . $a->patient?->lname,
            'Doctor' => $a->doctor?->fname . ' ' . $a->doctor?->lname,
            'Booked By' => $a->bookedBy?->fname . ' ' . $a->bookedBy?->lname,
            'Status' => ucfirst($a->status)
        ])->toArray();

        $cards = [['label' => 'Total Appointments', 'value' => (int) $q->count(), 'numeric_value' => (int) $q->count(), 'color' => '#007bff', 'icon' => 'zmdi-calendar']];

        $statuses = (clone $q)->reorder()->select('status')->distinct()->pluck('status');
        foreach ($statuses as $status) {
            $count = (int) (clone $q)->where('status', $status)->count();
            $cards[] = [
                'label' => ucfirst($status),
                'value' => $count,
                'numeric_value' => $count,
                'color' => match ($status) {
                    'completed' => '#28a745',
                    'pending' => '#ffc107',
                    'cancelled' => '#dc3545',
                    default => '#6c757d'
                },
                'icon' => 'zmdi-check'
            ];
        }

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(date) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(date)'))
            ->orderByDesc(DB::raw('DATE(date)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['doctor_id', 'status'], 'chart' => $chart];
    }

    // ---------------- LAB TESTS ----------------
    private function labTestReportArray(Request $r): array
    {
        $mode = $r->get('mode', 'summarised');
        $from = $r->get('from_date');
        $to = $r->get('to_date');
        $field = $r->get('field');
        $value = $r->get('value');

        $q = LabTest::with('patient', 'doctor');
        $this->applyDateRange($q, 'created_at', $from, $to);

        if ($field && $value && in_array($field, $this->getTableColumns('lab_tests'))) {
            $q->where($field, $value);
        }

        if ($mode === 'parameterised') {
            return $this->parameterisedArray($q, 'lab_tests', $field);
        }

        return match ($mode) {
            'summarised' => $this->labTestSummarised($q),
            'detailed' => $this->labTestDetailed($q),
            default => $this->labTestSummarised($q)
        };
    }

    private function labTestSummarised($q): array
    {
        $total = (int) $q->count();
        $statuses = ['completed', 'pending'];

        $cards = [
            ['label' => 'Total Lab Tests', 'value' => $total, 'numeric_value' => $total, 'color' => '#6f42c1', 'icon' => 'zmdi-flask']
        ];

        foreach ($statuses as $status) {
            $count = (int) (clone $q)->where('status', $status)->count();
            $cards[] = [
                'label' => ucfirst($status),
                'value' => $count,
                'numeric_value' => $count,
                'color' => $status == 'completed' ? '#28a745' : '#ffc107',
                'icon' => $status == 'completed' ? 'zmdi-check' : 'zmdi-time'
            ];
        }

        $rows = $q->latest()->limit(50)->get();
        $table = $rows->map(fn($l) => [
            'ID' => $l->id,
            'Patient' => $l->patient?->fname . ' ' . $l->patient?->lname,
            'Test' => $l->test_name,
            'Status' => ucfirst($l->status),
            'Result' => $l->results ?? '-',
        ])->toArray();

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['status'], 'chart' => $chart];
    }

    private function labTestDetailed($q): array
    {
        $rows = $q->latest()->limit(100)->get();
        $table = $rows->map(fn($l) => [
            'ID' => $l->id,
            'Patient' => $l->patient?->fname . ' ' . $l->patient?->lname,
            'Test' => $l->test_name,
            'Status' => ucfirst($l->status),
            'Result' => $l->results ?? '-',
            'Created' => $l->created_at->format('Y-m-d H:i'),
        ])->toArray();

        $statuses = ['completed', 'pending'];
        $cards = [['label' => 'Total Lab Tests', 'value' => (int) $q->count(), 'numeric_value' => (int) $q->count(), 'color' => '#6f42c1', 'icon' => 'zmdi-flask']];

        foreach ($statuses as $status) {
            $count = (int) (clone $q)->where('status', $status)->count();
            $cards[] = [
                'label' => ucfirst($status),
                'value' => $count,
                'numeric_value' => $count,
                'color' => $status == 'completed' ? '#28a745' : '#ffc107',
                'icon' => $status == 'completed' ? 'zmdi-check' : 'zmdi-time'
            ];
        }

        $chart = $q
            ->reorder()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderByDesc(DB::raw('DATE(created_at)'))
            ->limit(30)
            ->get()
            ->map(fn($r) => ['date' => $r->date, 'total' => (int) $r->total])
            ->toArray();

        return ['cards' => $cards, 'table' => $table, 'fields' => ['status'], 'chart' => $chart];
    }

    public function getFields(Request $request)
    {
        $type = $request->get('type');
        $mode = $request->get('mode');

        if (!isset($this->allowedFields[$type])) {
            return response()->json(['success' => false, 'columns' => []], 400);
        }

        // Only return allowed fields for parameterised mode
        $columns = $mode === 'parameterised' ? $this->allowedFields[$type] : [];

        return response()->json(['success' => true, 'columns' => $columns]);
    }


}
