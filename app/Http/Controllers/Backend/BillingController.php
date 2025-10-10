<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\HospitalService;
use App\Models\Patient;
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
        $services = HospitalService::all();

        // Optional: pre-fill if coming from appointment/pharmacy
        $billableType = $request->query('billable_type');
        $billableId = $request->query('billable_id');

        return view('backend.billings.create', compact('patients', 'services', 'billableType', 'billableId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $billing = Billing::create([
                'patient_id' => $validated['patient_id'],
                'amount' => $validated['amount'],
                'payment_method' => $request->payment_method,
                'status' => $request->status ?? 'unpaid',
            ]);

            foreach ($validated['items'] as $item) {
                $billing->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['quantity'] * $item['unit_price'],
                    'hospital_service_id' => $item['hospital_service_id'] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('billings')->with('success', 'Billing saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save billing: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $billing = Billing::findOrFail($id);
        return view('backend.billings.edit', compact('billing'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'billable_type' => 'required|string',
            'billable_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $billing = Billing::findOrFail($id);

            $billing->update([
                'patient_id' => $request->patient_id,
                'billable_type' => $request->billable_type,
                'billable_id' => $request->billable_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('billings')->with('success', 'Billing updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('billings')->with('error', 'Billing update failed');
        }
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

    public function fetchPatientServices(Patient $patient)
    {
        try {
            // Get latest appointment for the patient (adjust column if appointments reference users instead)
            $appointment = Appointment::where('patient_id', $patient->id)
                ->with(['labTests', 'pharmacyOrder'])
                ->latest()
                ->first();

            if (!$appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'No appointment found for this patient.'
                ]);
            }

            $items = [];

            // 1) Consultation fee (if you store it as hospital service)
            $consultation = HospitalService::where('category', 'consultation')->first();
            if ($consultation) {
                $items[] = [
                    'description' => 'Doctor Consultation',
                    'quantity' => 1,
                    'unit_price' => (float) $consultation->price,
                    'subtotal' => (float) $consultation->price,
                    'hospital_service_id' => $consultation->id,
                ];
            }

            // 2) Lab tests attached to appointment
            if ($appointment->labTests && $appointment->labTests->count()) {
                $labServiceTemplate = HospitalService::where('category', 'lab')->first();
                foreach ($appointment->labTests as $lab) {
                    $unitPrice = $labServiceTemplate ? (float) $labServiceTemplate->price : 0.0;
                    $items[] = [
                        'description' => $lab->test_name ?? 'Lab Test',
                        'quantity' => 1,
                        'unit_price' => $unitPrice,
                        'subtotal' => $unitPrice,
                        'hospital_service_id' => $labServiceTemplate ? $labServiceTemplate->id : null,
                    ];
                }
            }

            // 3) Pharmacy (if a pharmacy order exists and you want a fixed dispensing fee)
            if ($appointment->pharmacyOrder) {
                $pharmService = HospitalService::where('category', 'pharmacy')->first();
                $unitPrice = $pharmService ? (float) $pharmService->price : 0.0;
                $items[] = [
                    'description' => 'Pharmacy Items Dispensed',
                    'quantity' => 1,
                    'unit_price' => $unitPrice,
                    'subtotal' => $unitPrice,
                    'hospital_service_id' => $pharmService ? $pharmService->id : null,
                ];

                // Optionally: you can also push each pharmacy_order_item as separate billing items
                // if you want patient to be billed per-drug (expand here if needed).
            }

            return response()->json([
                'success' => true,
                'items' => $items,
            ]);
        } catch (\Exception $e) {
            \Log::error('Fetch Patient Services Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error while fetching services.'
            ], 500);
        }
    }

}
