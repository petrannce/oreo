<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Mail\PatientReceiptMail;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\HospitalService;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;

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
                $appointment = Appointment::with(['labRequirements', 'pharmacyOrder.items.medicine'])
                    ->where('patient_id', $patient->id)
                    ->latest()
                    ->first();

                if ($appointment) {
                    // 1. TRIAGE
                    $triageService = HospitalService::where('name', 'like', '%triage%')->first();
                    if ($triageService) {
                        $items[] = [
                            'hospital_service_id' => $triageService->id,
                            'description' => $triageService->name,
                            'quantity' => 1,
                            'unit_price' => (float) $triageService->price, // ✅ Use price, not rate
                        ];
                    }

                    // 2. CONSULTATION
                    $consultationService = null;
                    if ($appointment->hospital_service_id) {
                        $consultationService = HospitalService::find($appointment->hospital_service_id);
                    }
                    if (!$consultationService) {
                        $consultationService = HospitalService::where('name', 'like', '%consultation%')->first();
                    }
                    if ($consultationService) {
                        $items[] = [
                            'hospital_service_id' => $consultationService->id,
                            'description' => $consultationService->name,
                            'quantity' => 1,
                            'unit_price' => (float) $consultationService->price,
                        ];
                    }

                    // 3. LAB TESTS
                    $labService = HospitalService::where('name', 'like', '%lab%')->first();
                    $labTotal = 0;

                    if ($appointment->labRequirements && $appointment->labRequirements->count() > 0) {
                        foreach ($appointment->labRequirements as $lab) {
                            $labTotal += (float) ($lab->price ?? $lab->amount ?? 0);
                        }
                    }

                    if ($labService && $labTotal > 0) {
                        $items[] = [
                            'hospital_service_id' => $labService->id,
                            'description' => $labService->name,
                            'quantity' => 1,
                            'unit_price' => $labTotal,
                        ];
                    }

                    // 4. PHARMACY ITEMS
                    if ($appointment->pharmacyOrder && $appointment->pharmacyOrder->items->count() > 0) {
                        foreach ($appointment->pharmacyOrder->items as $phItem) {
                            $items[] = [
                                'hospital_service_id' => null,
                                'description' => $phItem->medicine->name ?? 'Medicine',
                                'quantity' => (int) $phItem->quantity,
                                'unit_price' => (float) $phItem->unit_price,
                            ];
                        }
                    }
                }
            }
        }

        return view('backend.billings.create', compact('patients', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Find latest appointment for that patient
            $appointment = Appointment::where('patient_id', $request->patient_id)
                ->latest()
                ->first();

            // 2️⃣ Create billing record
            $billing = Billing::create([
                'patient_id' => $request->patient_id,
                'billable_id' => $appointment?->id,                   // Link to the latest appointment
                'billable_type' => $appointment ? Appointment::class : null, // Define polymorphic link
                'hospital_service_id' => null,                                // Items handle their own services
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'unpaid',
            ]);

            // 3️⃣ Store billing items (each line item from the form)
            foreach ($request->items as $item) {
                $billing->billingItems()->create([
                    'hospital_service_id' => $item['hospital_service_id'] ?? null,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // 4️⃣ Update billing total (sum of all items)
            $billing->update([
                'amount' => $billing->billingItems->sum('subtotal'),
            ]);

            DB::commit();

            return redirect()
                ->route('billings', $billing->id)
                ->with('success', 'Billing created successfully!');

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Billing creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create billing. Please try again.');
        }
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

        // ✅ Send email with attached receipt if billing is marked paid
        if ($billing->status === 'paid' && $billing->patient && $billing->patient->email) {
            try {
                // 🧾 Generate PDF receipt from view
                $pdf = PDF::loadView('backend.billings.receipt', compact('billing'));

                // Send email with PDF attached
                Mail::to($billing->patient->email)->send(new PatientReceiptMail($billing, $pdf));

            } catch (\Exception $e) {
                \Log::error('❌ Failed to send receipt email: ' . $e->getMessage());
            }
        }

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

    public function resendEmail($id)
    {
        $billing = Billing::with(['patient', 'items'])->findOrFail($id);

        if ($billing->status !== 'paid') {
            return back()->with('error', 'Only paid bills can have receipts emailed.');
        }

        $pdf = PDF::loadView('backend.billings.receipt', compact('billing'));
        Mail::to($billing->patient->email)->send(new PatientReceiptMail($billing, $pdf));

        return back()->with('success', 'Receipt re-sent successfully.');
    }


}
