<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Doctor;
use App\Models\LabTechnician;
use App\Models\LabTest;
use App\Models\Medical;
use App\Models\Medicine;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ReportController extends Controller
{

    public function dashboard(Request $request)
{
    // Basic initial counts for cards
    $appointments = Appointment::query();
    $billings = Billing::query();
    $users = User::query();
    $patients = Patient::query();

    return view('backend.dashboard.reports', [
        'appointments' => $appointments->limit(5)->get(), // sample
        'billings' => $billings->latest()->limit(10)->get(),
        'users' => $users->get(),
        'patients' => $patients->get(),
        // available report types (used to populate dropdown)
        'reportTypes' => [
            'billings' => 'Billings',
            'appointments' => 'Appointments',
            'patients' => 'Patients',
            'lab_tests' => 'Lab Tests',
            // add more later
        ],
    ]);
}

  public function filterData(Request $request)
    {
        $type = $request->get('type', 'billings');

        switch ($type) {
            case 'billings':
                return $this->billingReport($request);
            case 'patients':
                return $this->patientReport($request);
            case 'appointments':
                return $this->appointmentReport($request);
            case 'lab_tests':
                return $this->labTestReport($request);
            default:
                return response()->json(['cards' => [], 'table' => [], 'fields' => []]);
        }
    }

    // ------------------------------
    //  BILLING REPORT
    // ------------------------------
    private function billingReport(Request $request)
    {
        $mode   = $request->get('mode', 'summarised');
        $from   = $request->get('from_date');
        $to     = $request->get('to_date');
        $field  = $request->get('field');
        $value  = $request->get('value');

        $query = Billing::with('patient');
        $this->applyDateRange($query, 'created_at', $from, $to);

        if ($field && $value && in_array($field, ['payment_method', 'status'])) {
            $query->where($field, $value);
        }

        switch ($mode) {
            case 'summarised':
                return $this->billingSummarised($query);
            case 'detailed':
                return $this->billingDetailed($query);
            case 'parameterised':
                return $this->billingParameterised($field);
            default:
                return response()->json(['cards' => [], 'table' => [], 'fields' => []]);
        }
    }

    private function billingSummarised($query)
    {
        $cards = [
            ['label' => 'Total Bills', 'value' => $query->count(), 'color' => '#007bff', 'icon' => 'zmdi-receipt'],
            ['label' => 'Total Amount (KES)', 'value' => number_format($query->sum('amount'), 2), 'color' => '#6f42c1', 'icon' => 'zmdi-money'],
            ['label' => 'Paid Bills', 'value' => $query->where('status', 'paid')->count(), 'color' => '#28a745', 'icon' => 'zmdi-check-circle'],
            ['label' => 'Unpaid Bills', 'value' => $query->where('status', 'unpaid')->count(), 'color' => '#ffc107', 'icon' => 'zmdi-time'],
        ];

        $rows = $query->latest()->limit(20)->get();
        $table = $rows->map(function ($b) {
            return [
                'Patient' => $b->patient->fname . ' ' . $b->patient->lname,
                'Amount' => number_format($b->amount, 2),
                'Payment Method' => $b->payment_method ?? '-',
                'Status' => ucfirst($b->status),
                'Date' => $b->created_at->format('Y-m-d'),
            ];
        })->toArray();

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => ['payment_method', 'status']]);
    }

    private function billingDetailed($query)
    {
        $rows = $query->latest()->limit(100)->get();
        $table = $rows->map(function ($b) {
            return [
                'ID' => $b->id,
                'Patient' => $b->patient->fname . ' ' . $b->patient->lname,
                'Billable Type' => class_basename($b->billable_type),
                'Billable ID' => $b->billable_id,
                'Amount' => number_format($b->amount, 2),
                'Payment Method' => $b->payment_method ?? '-',
                'Status' => ucfirst($b->status),
                'Created' => $b->created_at->format('Y-m-d H:i'),
            ];
        })->toArray();

        $cards = [
            ['label' => 'Detailed Bills', 'value' => $query->count(), 'color' => '#17a2b8', 'icon' => 'zmdi-assignment'],
            ['label' => 'Total Amount', 'value' => number_format($query->sum('amount'), 2), 'color' => '#6610f2', 'icon' => 'zmdi-balance-wallet'],
        ];

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => ['payment_method', 'status']]);
    }

    private function billingParameterised(?string $field)
    {
        if (!$field) {
            return response()->json(['fields' => ['payment_method', 'status']]);
        }

        $groups = Billing::select($field, DB::raw('COUNT(*) as total'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy($field)->get();

        $cards = $groups->map(function ($g) use ($field) {
            return [
                'label' => ucfirst($g->{$field} ?? '—'),
                'value' => $g->total . ' (KES ' . number_format($g->total_amount, 2) . ')',
                'color' => $g->{$field} === 'paid' ? '#28a745' : '#ffc107',
                'icon' => 'zmdi-chart',
            ];
        })->toArray();

        $table = $groups->map(function ($g) use ($field) {
            return [
                ucfirst($field) => $g->{$field} ?? '—',
                'Count' => $g->total,
                'Total (KES)' => number_format($g->total_amount, 2)
            ];
        })->toArray();

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => [$field]]);
    }

    // ------------------------------
    //  OTHER MODELS
    // ------------------------------

    private function patientReport(Request $request)
    {
        $query = Patient::query();
        $this->applyDateRange($query, 'created_at', $request->from_date, $request->to_date);

        $cards = [['label' => 'Total Patients', 'value' => $query->count(), 'color' => '#17a2b8', 'icon' => 'zmdi-accounts']];
        $table = $query->latest()->limit(50)->get(['id', 'fname', 'lname', 'email', 'phone_number'])
            ->map(fn($p) => [
                'ID' => $p->id,
                'Name' => $p->fname . ' ' . $p->lname,
                'Email' => $p->email ?? '-',
                'Phone' => $p->phone_number ?? '-',
            ])->toArray();

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => []]);
    }

    private function appointmentReport(Request $request)
    {
        $query = Appointment::with('patient', 'doctor');
        $this->applyDateRange($query, 'date', $request->from_date, $request->to_date);

        $cards = [['label' => 'Appointments', 'value' => $query->count(), 'color' => '#007bff', 'icon' => 'zmdi-calendar']];
        $table = $query->latest()->limit(50)->get()
            ->map(fn($a) => [
                'ID' => $a->id,
                'Date' => $a->date,
                'Patient' => $a->patient->fname . ' ' . $a->patient->lname,
                'Doctor' => $a->doctor->fname . ' ' . $a->doctor->lname,
                'Status' => $a->status,
            ])->toArray();

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => []]);
    }

    private function labTestReport(Request $request)
    {
        $query = LabTest::with('patient', 'doctor');
        $this->applyDateRange($query, 'created_at', $request->from_date, $request->to_date);

        $cards = [['label' => 'Lab Tests', 'value' => $query->count(), 'color' => '#6f42c1', 'icon' => 'zmdi-flask']];
        $table = $query->latest()->limit(50)->get()
            ->map(fn($l) => [
                'ID' => $l->id,
                'Patient' => $l->patient->fname . ' ' . $l->patient->lname,
                'Test' => $l->test_name,
                'Status' => ucfirst($l->status),
            ])->toArray();

        return response()->json(['cards' => $cards, 'table' => $table, 'fields' => []]);
    }

    // ------------------------------
    //  HELPER
    // ------------------------------
    private function applyDateRange($query, string $column, ?string $from, ?string $to): void
    {
        if ($from && $to) {
            $query->whereBetween($column, [$from, $to]);
        } elseif ($from) {
            $query->whereDate($column, '>=', $from);
        } elseif ($to) {
            $query->whereDate($column, '<=', $to);
        }
    }

    public function generate(Request $request)
    {
        $type = $request->get('type');
        $format = $request->get('format', 'pdf'); // pdf | csv | excel
        $from = $request->get('from_date');
        $to = $request->get('to_date');

        // 👇 Define report mapping
        $reports = [

            'appointments' => [
                'model' => Appointment::class,
                'relations' => ['patient', 'doctor', 'service'],
                'columns' => ['date', 'patient.name', 'doctor.name', 'service.name', 'status', 'created_at'],
                'title' => 'Appointments Report',
                'date_field' => 'date',
            ],
            'billings' => [
                'model' => Billing::class,
                'relations' => ['patient'],
                'columns' => ['patient.name', 'amount', 'payment_method', 'status', 'created_at'],
                'title' => 'Billing Report',
                'date_field' => 'created_at',
            ],
            'doctors' => [
                'model' => Doctor::class,
                'relations' => ['user', 'appointments'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Doctors Report',
                'date_field' => 'created_at',
            ],
            'lab_technicians' => [
                'model' => LabTechnician::class,
                'relations' => ['user', 'labTests'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Lab Technicians Report',
                'date_field' => 'created_at',
            ],
            'lab_tests' => [
                'model' => LabTest::class,
                'relations' => ['patient', 'doctor', 'labTechnician'],
                'columns' => ['patient.name', 'doctor.name', 'test_name', 'status', 'results', 'created_at'],
                'title' => 'Lab Tests Report',
                'date_field' => 'created_at',
            ],
            'medicines' => [
                'model' => Medicine::class,
                'relations' => [],
                'columns' => ['name', 'category', 'form', 'stock_quantity', 'unit_price', 'manufacturer', 'created_at'],
                'title' => 'Medicines Report',
                'date_field' => 'created_at',
            ],
            'medical_records' => [
                'model' => Medical::class,
                'relations' => ['patient', 'doctor', 'appointment'],
                'columns' => ['patient.name', 'doctor.name', 'appointment.date', 'created_at'],
                'title' => 'Medical Records Report',
                'date_field' => 'created_at',
            ],
            'nurses' => [
                'model' => Nurse::class,
                'relations' => ['user', 'appointments'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Nurses Report',
                'date_field' => 'created_at',
            ],
            'patients' => [
                'model' => Patient::class,
                'relations' => ['appointments'],
                'columns' => ['fname', 'lname', 'email', 'phone number', 'gender', 'country', 'created_at'],
                'title' => 'Patients Report',
                'date_field' => 'created_at',
            ],
            'pharmacy_orders' => [
                'model' => \App\Models\PharmacyOrder::class,
                'relations' => ['patient', 'doctor', 'appointment'],
                'columns' => ['appointment.id', 'patient.fname', 'patient.lname', 'doctor.fname', 'doctor.lname', 'medical_record_id', 'status', 'created_at'],
                'title' => 'Pharmacy Orders Report',
                'date_field' => 'created_at',
            ],
            'pharmacy_orders_items' => [
                'model' => \App\Models\PharmacyOrderItem::class,
                'relations' => ['pharmacyOrder', 'medicine'],
                'columns' => ['pharmacyOrder.patient.name', 'pharmacyOrder.pharmacy.name', 'medicine.name', 'quantity', 'created_at'],
                'title' => 'Pharmacy Orders Items Report',
                'date_field' => 'created_at',
            ],
            'receptionists' => [
                'model' => \App\Models\Receptionist::class,
                'relations' => ['user', 'appointments'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Receptionists Report',
                'date_field' => 'created_at',
            ],
            'departments' => [
                'model' => \App\Models\Department::class,
                'relations' => [],
                'columns' => ['name', 'created_at'],
                'title' => 'Departments Report',
                'date_field' => 'created_at',
            ],
            'triages' => [
                'model' => \App\Models\Triage::class,
                'relations' => ['patient', 'nurse'],
                'columns' => ['patient.name', 'nurse.name', 'temperature', 'blood_pressure', 'weight', 'created_at'],
                'title' => 'Triages Report',
                'date_field' => 'created_at',
            ],
            'users' => [
                'model' => \App\Models\User::class,
                'relations' => ['profile'],
                'columns' => ['fname', 'lname', 'username', 'email', 'role', 'profile.status', 'created_at'],
                'title' => 'Users Report',
                'date_field' => 'created_at',
            ],

        ];

        if (!array_key_exists($type, $reports)) {
            return back()->with('error', 'Invalid report type selected.');
        }

        $config = $reports[$type];

        $query = $config['model']::with($config['relations']);

        // Apply date filters dynamically
        if ($from && $to) {
            $query->whereBetween($config['date_field'], [$from, $to]);
        } elseif ($from) {
            $query->whereDate($config['date_field'], '>=', $from);
        } elseif ($to) {
            $query->whereDate($config['date_field'], '<=', $to);
        }

        $data = $query->get();

        $filters = [
            'from_date' => $from,
            'to_date' => $to,
        ];

        // PDF Export
        if ($format === 'pdf') {
            $pdf = Pdf::loadView('backend.reports.universal', [
                'title' => $config['title'],
                'columns' => $config['columns'],
                'data' => $data,
                'filters' => $filters,
            ]);

            return $pdf->download(strtolower(str_replace(' ', '_', $config['title'])) . '.pdf');
        }

        // CSV / Excel Export
        $rows = $data->map(function ($item) use ($config) {
            $row = [];
            foreach ($config['columns'] as $col) {
                $row[$col] = data_get($item, $col, '—');
            }
            return $row;
        });

        $export = new ArrayExport($rows->toArray());

        if ($format === 'csv') {
            return Excel::download($export, strtolower($type) . '-report.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        if ($format === 'excel') {
            return Excel::download($export, strtolower($type) . '-report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        return back()->with('error', 'Invalid format selected.');
    }
}
