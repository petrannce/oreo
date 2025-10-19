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
           
            'appointments' => [
                'model' => \App\Models\Appointment::class,
                'relations' => ['patient', 'doctor', 'service'],
                'columns' => ['date', 'patient.name', 'doctor.name', 'service.name', 'status', 'created_at'],
                'title' => 'Appointments Report',
                'date_field' => 'date',
            ],
            'billings' => [
                'model' => \App\Models\Billing::class,
                'relations' => ['patient'],
                'columns' => ['patient.name', 'amount', 'payment_method', 'status', 'created_at'],
                'title' => 'Billing Report',
                'date_field' => 'created_at',
            ],
            'doctors' => [
                'model' => \App\Models\Doctor::class,
                'relations' => ['user', 'appointments'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Doctors Report',
                'date_field' => 'created_at',
            ],
            'lab_technicians' => [
                'model' => \App\Models\LabTechnician::class,
                'relations' => ['user', 'labTests'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Lab Technicians Report',
                'date_field' => 'created_at',
            ],
            'lab_tests' => [
                'model' => \App\Models\LabTest::class,
                'relations' => ['patient', 'doctor', 'labTechnician'],
                'columns' => ['patient.name', 'doctor.name', 'test_name', 'status', 'results', 'created_at'],
                'title' => 'Lab Tests Report',
                'date_field' => 'created_at',
            ],
            'medicines' => [
                'model' => \App\Models\Medicine::class,
                'relations' => [],
                'columns' => ['name', 'category', 'form', 'stock_quantity', 'unit_price', 'manufacturer', 'created_at'],
                'title' => 'Medicines Report',
                'date_field' => 'created_at',
            ],
            'medical_records' => [
                'model' => \App\Models\Medical::class,
                'relations' => ['patient', 'doctor', 'appointment'],
                'columns' => ['patient.name', 'doctor.name', 'appointment.date', 'created_at'],
                'title' => 'Medical Records Report',
                'date_field' => 'created_at',
            ],
            'nurses' => [
                'model' => \App\Models\Nurse::class,
                'relations' => ['user', 'appointments'],
                'columns' => ['user.fname', 'user.lname', 'user.username', 'user.email', 'user.role', 'user.profile.status', 'created_at'],
                'title' => 'Nurses Report',
                'date_field' => 'created_at',
            ],
            'patients' => [
                'model' => \App\Models\Patient::class,
                'relations' => ['appointments'],
                'columns' => ['fname', 'lname', 'email', 'phone number', 'gender', 'country', 'created_at'],
                'title' => 'Patients Report',
                'date_field' => 'created_at',
            ],
            'pharmacy_orders' => [
                'model' => \App\Models\PharmacyOrder::class,
                'relations' => ['patient', 'pharmacy'],
                'columns' => ['patient.name', 'pharmacy.name', 'created_at'],
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
