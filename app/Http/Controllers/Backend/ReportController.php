<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $type = $request->get('type');
        $format = $request->get('format', 'pdf'); // pdf | csv | excel
        $from = $request->get('from_date');
        $to = $request->get('to_date');

        if (!$type) {
            return back()->with('error', 'Please select a report type.');
        }

        // 👇 Define report mapping
        $reports = [
            'users' => [
                'model' => \App\Models\User::class,
                'relations' => ['profile'],
                'columns' => ['fname', 'lname', 'username', 'email', 'role', 'profile.status', 'created_at'],
                'title' => 'Users Report',
                'date_field' => 'created_at',
            ],
            'appointments' => [
                'model' => \App\Models\Appointment::class,
                'relations' => ['patient', 'doctor', 'service'],
                'columns' => ['date', 'patient.name', 'doctor.name', 'service.name', 'status', 'created_at'],
                'title' => 'Appointments Report',
                'date_field' => 'date',
            ],
            'triages' => [
                'model' => \App\Models\Triage::class,
                'relations' => ['patient', 'nurse'],
                'columns' => ['patient.name', 'nurse.name', 'temperature', 'blood_pressure', 'weight', 'created_at'],
                'title' => 'Triages Report',
                'date_field' => 'created_at',
            ],
            'lab_tests' => [
                'model' => \App\Models\LabTest::class,
                'relations' => ['patient', 'doctor', 'labTechnician'],
                'columns' => ['patient.name', 'doctor.name', 'test_name', 'status', 'results', 'created_at'],
                'title' => 'Lab Tests Report',
                'date_field' => 'created_at',
            ],
            'billings' => [
                'model' => \App\Models\Billing::class,
                'relations' => ['patient'],
                'columns' => ['patient.name', 'amount', 'payment_method', 'status', 'created_at'],
                'title' => 'Billing Report',
                'date_field' => 'created_at',
            ],
            'pharmacy_order_items' => [
                'model' => \App\Models\PharmacyOrderItem::class,
                'relations' => ['pharmacyOrder.patient', 'pharmacyOrder.doctor'],
                'columns' => ['pharmacyOrder.patient.name', 'pharmacyOrder.doctor.name', 'drug_name', 'quantity', 'dosage', 'created_at'],
                'title' => 'Pharmacy Orders Report',
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
