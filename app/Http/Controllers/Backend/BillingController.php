<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\HospitalService;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;

class BillingController extends Controller
{
    public function index()
    {
        $billings = Billing::with(['patient', 'items', 'billable'])->latest()->get();
        return view('backend.billings.index', compact('billings'));
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        $items = [];

        if ($request->filled('patient_id')) {
            $patient = Patient::find($request->patient_id);
            if ($patient) {
                $appointment = $patient->appointments()->latest()->first();
                if ($appointment) {
                    // Triage
                    if ($triage = HospitalService::where('name', 'triage')->first()) {
                        $items[] = [
                            'hospital_service_id' => $triage->id,
                            'description' => $triage->name,
                            'quantity' => 1,
                            'unit_price' => $triage->price,
                        ];
                    }

                    // Consultation / Service
                    if ($appointment->service) {
                        $items[] = [
                            'hospital_service_id' => $appointment->service->id,
                            'description' => $appointment->service->name,
                            'quantity' => 1,
                            'unit_price' => $appointment->service->price,
                        ];
                    }

                    // Lab
                    if ($appointment->labTest) {
                        $labService = HospitalService::where('name', 'like', '%lab%')->first();
                        if ($labService) {
                            $items[] = [
                                'hospital_service_id' => $labService->id,
                                'description' => $appointment->labTest->name,
                                'quantity' => 1,
                                'unit_price' => $appointment->labTest->price,
                            ];
                        }
                    }

                    // Pharmacy
                    foreach ($appointment->pharmacyOrder?->items ?? [] as $phItem) {
                        $items[] = [
                            'hospital_service_id' => null,
                            'description' => $phItem->medicine->name,
                            'quantity' => $phItem->quantity,
                            'unit_price' => $phItem->unit_price,
                        ];
                    }
                }
            }
        }

        return view('backend.billings.create', compact('patients', 'items'));
    }

    public function store(Request $request)
    {

        // Validate the form
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount from items
        $totalAmount = collect($request->items)->reduce(function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['unit_price']);
        }, 0);

        // Create billing
        $billing = new Billing();
        $billing->patient_id = $request->patient_id;
        $billing->amount = $totalAmount;
        $billing->payment_method = $request->payment_method;
        $billing->status = 'unpaid'; // default
        $billing->save();

        // Create billing items
        foreach ($request->items as $item) {
            $billing->items()->create([
                'hospital_service_id' => $item['hospital_service_id'] ?? null,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('billings')->with('success', 'Billing created successfully!');
    }


    public function edit($id)
    {
        $billing = Billing::with('items.hospitalService', 'patient')->findOrFail($id);
        return view('backend.billings.edit', compact('billing'));
    }

    public function update(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);

        $billing->update([
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);

        return redirect()->route('billings.edit', $billing->id)
            ->with('success', 'Billing updated successfully.');
    }

    public function show($id)
    {
        $billing = Billing::with('items', 'patient')->findOrFail($id);
        return view('backend.billings.show', compact('billing'));
    }

    public function destroy($id)
    {
        DB::table('billings')->where('id', $id)->delete();
        return redirect()->route('billings')->with('success', 'Billing deleted successfully');
    }

    public function report(Request $request)
    {
        $billings = Billing::all();
        //start query - don't call get() yet
        $query = Billing::with(['patient']);

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $billings = $query->latest()->paginate(10);

        return view('backend.billings.reports', [
            'billings' => $billings,
            'canExport' => true
        ]);
    }

    public function markReady($id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update(['status' => 'paid']);

        return redirect()->route('billings.show', $billing->id)
            ->with('success', 'Final bill is ready for printing.');
    }

    public function showReceipt(Billing $billing)
    {
        return view('backend.billings.receipt', compact('billing'));
    }

    public function downloadPDF(Billing $billing)
    {
        // Load relationships
        $billing->load(['patient', 'items']);

        // Generate PDF from the receipt view
        $pdf = Pdf::loadView('backend.billings.receipt_pdf', compact('billing'));

        // Download as PDF
        $filename = 'Bill_' . str_pad($billing->id, 5, '0', STR_PAD_LEFT) . '.pdf';
        return $pdf->download($filename);
    }

    public function fetchServices(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($request->patient_id);

        // Start with default payment method
        $payment_method = $request->payment_method ?? 'cash';

        $items = [];

        $appointment = $patient->appointments()->latest()->first();
        if ($appointment) {
            // 1️⃣ Triage
            $triage = HospitalService::where('name', 'triage')->first();
            if ($triage) {
                $items[] = [
                    'hospital_service_id' => $triage->id,
                    'description' => $triage->name,
                    'quantity' => 1,
                    'unit_price' => $triage->price,
                ];
            }

            // 2️⃣ Consultation / Hospital service
            if ($appointment->service) {
                $service = $appointment->service;
                $items[] = [
                    'hospital_service_id' => $service->id,
                    'description' => $service->name,
                    'quantity' => 1,
                    'unit_price' => $service->price,
                ];
            }

            // 3️⃣ Lab Tests
            if ($appointment->labTest) {
                $labService = HospitalService::where('name', 'like', '%lab%')->first();
                if ($labService) {
                    $items[] = [
                        'hospital_service_id' => $labService->id,
                        'description' => $appointment->labTest->name,
                        'quantity' => 1,
                        'unit_price' => $appointment->labTest->price,
                    ];
                }
            }

            // 4️⃣ Pharmacy
            if ($appointment->pharmacyOrder && $appointment->pharmacyOrder->items->count()) {
                foreach ($appointment->pharmacyOrder->items as $phItem) {
                    $items[] = [
                        'hospital_service_id' => null,
                        'description' => $phItem->medicine->name,
                        'quantity' => $phItem->quantity,
                        'unit_price' => $phItem->unit_price,
                    ];
                }
            }
        }

        return view('backend.billings.create', [
            'patients' => Patient::all(),
            'selectedPatient' => $patient,
            'payment_method' => $payment_method,
            'fetchedItems' => $items,
        ]);
    }

    public function markAsPaid($id)
    {
        $billing = Billing::with('billable')->findOrFail($id);

        // Update the billing status
        $billing->update(['status' => 'paid']);

        // Check if the billing is linked to an appointment
        if ($billing->billable_type === 'Appointment' && $billing->billable_id) {
            $appointment = Appointment::find($billing->billable_id);

            if ($appointment && $appointment->process_stage !== 'completed') {
                $appointment->update(['process_stage' => 'completed']);
            }
        }

        return redirect()
            ->route('billings.show', $billing->id)
            ->with('success', 'Bill marked as paid successfully. Appointment moved to completed stage.');
    }

    /**
     * Mark a billing as cancelled.
     */
    public function cancelPayment($id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update(['status' => 'cancelled']);

        return redirect()
            ->route('billings.show', $billing->id)
            ->with('info', 'Billing cancelled successfully.');
    }

}
