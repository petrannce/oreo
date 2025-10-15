<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medical;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PharmacyOrder;
use App\Models\PharmacyOrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;
use DB;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {

        $appointments = Appointment::with('patient', 'doctor', 'service')->get();

        return view('backend.appointments.index', [
            'appointments' => $appointments,
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        $services = Service::all();
        $doctors = User::where('role', 'doctor')->get();
        return view('backend.appointments.create', [
            'patients' => $patients,
            'services' => $services,
            'doctors' => $doctors
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'booked_by' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $appointment = new Appointment();
            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->service_id = $request->service_id;
            $appointment->booked_by = $request->booked_by;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->status = 'pending';

            $appointment->save();

            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error
            //dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Appointment creation failed');
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $services = Service::all();
        $doctors = User::where('role', 'doctor')->get();
        return view('backend.appointments.edit', compact('appointment', 'services', 'doctors'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'booked_by' => 'required',
            'date' => 'required',
            'time' => 'required',

        ]);

        DB::beginTransaction();
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->service_id = $request->service_id;
            $appointment->booked_by = $request->booked_by;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->status = 'pending';
            $appointment->save();

            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Appointment update failed');
        }
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('backend.appointments.view', compact('appointment'));
    }

    public function destroy($id)
    {
        DB::table('appointments')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully');
    }

    public function updateStatus($id, $status)
    {
        $appointment = Appointment::findOrFail($id);
        $validStatuses = ['approved', 'pending', 'cancelled', 'rejected'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status selected');
        }

        $appointment->status = $status;
        $appointment->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
    public function updateStage(Request $request, $id, $stage)
    {
        $appointment = Appointment::with(['patient', 'service', 'labTest', 'pharmacyOrder.items.medicine', 'billing'])
            ->findOrFail($id);

        // ✅ 1. Valid stages
        $validStages = [
            'reception',
            'triage',
            'doctor_consult',
            'lab',
            'pharmacy',
            'billing',
            'completed',
            'cancelled'
        ];

        if (!in_array($stage, $validStages)) {
            return back()->with('error', 'Invalid stage selected.');
        }

        // ✅ 2. Role-based permissions
        $user = Auth::user();
        $userRole = $user->role ?? null;

        $rolePermissions = [
            'receptionist' => ['reception', 'triage', 'cancelled'],
            'nurse' => ['triage', 'doctor_consult'],
            'doctor' => ['doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'],
            'lab_technician' => ['lab'],
            'pharmacist' => ['pharmacy', 'billing', 'completed'],
            'admin' => $validStages,
        ];

        if (!isset($rolePermissions[$userRole]) || !in_array($stage, $rolePermissions[$userRole])) {
            return back()->with('error', 'You do not have permission to move a patient to this stage.');
        }

        // ✅ 3. Prevent redundant stage move
        if ($appointment->process_stage === $stage) {
            return back()->with('info', 'Patient is already in this stage.');
        }

        /**
         * 🧠 4. SMART PRESCRIPTION PARSER + PHARMACY LOGIC
         */
        if ($stage === 'pharmacy') {
            $medicalRecord = Medical::where('appointment_id', $appointment->id)->latest()->first();

            if (!$medicalRecord || empty($medicalRecord->prescription)) {
                return back()->with('error', 'No prescriptions found for this patient.');
            }

            // Create or fetch existing pharmacy order
            $pharmacyOrder = PharmacyOrder::firstOrCreate(
                [
                    'appointment_id' => $appointment->id,
                    'medical_record_id' => $medicalRecord->id,
                ],
                [
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $medicalRecord->doctor_id,
                    'status' => 'pending',
                ]
            );

            // Clear old items
            if (method_exists($pharmacyOrder, 'items')) {
                $pharmacyOrder->items()->delete();
            }

            /**
             * 🧾 OPTION A: Use selected medicine IDs from form instead of free text parsing
             */
            $medicineIds = $request->input('medicine_ids', []); // hidden inputs from form
            $quantities = $request->input('quantities', []);
            $dosages = $request->input('dosages', []);
            $totalPrice = 0;

            foreach ($medicineIds as $index => $id) {
                $medicine = Medicine::find($id);
                if (!$medicine)
                    continue; // skip if medicine not found

                $quantity = $quantities[$index] ?? 1;
                $dosage = $dosages[$index] ?? 'Not specified';
                $subtotal = $medicine->unit_price * $quantity;

                PharmacyOrderItem::create([
                    'pharmacy_order_id' => $pharmacyOrder->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'dosage' => $dosage,
                    'unit_price' => $medicine->unit_price,
                    'subtotal' => $subtotal,
                ]);

                $totalPrice += $subtotal;
            }

            $pharmacyOrder->update([
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);
        }


        /**
         * 💰 5. AUTO-BILLING LOGIC
         */
        if ($stage === 'billing') {
            if (!$appointment->billing) {
                $totalAmount = 0;

                // Add service price
                $totalAmount += $appointment->service->price ?? 0;

                // Add lab test cost
                if ($appointment->labTest && $appointment->labTest->price) {
                    $totalAmount += $appointment->labTest->price;
                }

                // Add pharmacy order total
                if ($appointment->pharmacyOrder && $appointment->pharmacyOrder->items->count() > 0) {
                    $totalAmount += $appointment->pharmacyOrder->items->sum('subtotal');
                }

                // Create billing record
                $billing = \App\Models\Billing::create([
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                $appointment->billing_id = $billing->id;
                $appointment->save();
            }
        }

        /**
         * ✅ 6. COMPLETION VALIDATION
         */
        if ($stage === 'completed') {
            if (!$appointment->billing || $appointment->billing->status !== 'paid') {
                return back()->with('error', 'Cannot complete appointment before billing is paid.');
            }
        }

        /**
         * 🔄 7. Update process stage
         */
        $appointment->process_stage = $stage;
        $appointment->save();

        $message = 'Patient moved to ' . ucfirst(str_replace('_', ' ', $stage)) . ' stage successfully.';
        if ($stage === 'billing') {
            $message = 'Billing stage initiated successfully. Auto bill generated for patient.';
        }

        return back()->with('success', $message);
    }


    public function report(Request $request)
    {
        $user = Auth::user();
        $userRole = $user->getRoleNames()->first(); // Spatie role

        $appointments = Appointment::with(['patient', 'doctor', 'service', 'triage', 'labTest'])
            ->when($request->from_date, fn($query) => $query->whereDate('date', '>=', $request->from_date))
            ->when($request->to_date, fn($query) => $query->whereDate('date', '<=', $request->to_date))
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->latest()
            ->get();

        // Optional: expose allowed stages to the view if needed
        $rolePermissions = [
            'receptionist' => ['reception', 'triage', 'cancelled'],
            'nurse' => ['triage', 'doctor_consult'],
            'doctor' => ['doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'],
            'lab_technician' => ['lab'],
            'pharmacist' => ['pharmacy', 'billing', 'completed'],
            'admin' => ['reception', 'triage', 'doctor_consult', 'lab', 'pharmacy', 'billing', 'completed', 'cancelled'],
        ];
        $allowedStages = $rolePermissions[$userRole] ?? [];

        return view('backend.appointments.reports', [
            'appointments' => $appointments,
            'allowedStages' => $allowedStages,
            'canExport' => true
        ]);
    }

    public function labStatus($id)
    {
        $appointment = Appointment::with('labTest')->find($id);

        if (!$appointment || !$appointment->labTest) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json([
            'status' => $appointment->labTest->status ?? 'pending',
        ]);
    }



}
