<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\HospitalService;
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
        $appointment = Appointment::with(['patient', 'service', 'labTests', 'pharmacyOrder.items.medicine', 'billing'])
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
            'doctor' => ['doctor_consult', 'lab', 'pharmacy', 'billing'],
            'lab_technician' => ['lab', 'doctor_consult'],
            'pharmacist' => ['pharmacy', 'billing'],
            'accountant' => ['billing', 'completed'],
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
         * 🧠 4. SMART PRESCRIPTION → PHARMACY ORDER CREATION (Option A)
         */
        if ($stage === 'pharmacy') {
            // 1️⃣ Get latest medical record for this appointment
            $medicalRecord = Medical::where('appointment_id', $appointment->id)
                ->latest()
                ->first();

            if (!$medicalRecord || empty(trim($medicalRecord->prescription))) {
                return back()->with('error', 'No prescriptions found for this patient.');
            }

            // 2️⃣ Create or get pharmacy order
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

            // 3️⃣ Clear any old items to avoid duplication
            $pharmacyOrder->items()->delete();

            // 4️⃣ Split prescription text into lines
            $lines = preg_split('/\r\n|\r|\n/', trim($medicalRecord->prescription));

            $totalPrice = 0;

            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '')
                    continue;

                /**
                 * ✨ Attempt to extract medicine name, quantity & dosage
                 * Example: "Paracetamol 100 gms 4 1 tablet 3x daily"
                 */
                $medicineName = null;
                $quantity = 1;
                $dosage = $line;

                // Try to extract number from line (e.g., "4" means 4 quantities)
                if (preg_match('/(\d+)\s?(tabs?|tablets?|caps?|pcs?|x)?/i', $line, $match)) {
                    $quantity = (int) $match[1];
                }

                // Find medicine by fuzzy match
                $medicine = Medicine::where('name', 'like', '%' . strtok($line, ' ') . '%')->first();

                $unitPrice = $medicine->unit_price ?? 0;
                $subtotal = $unitPrice * $quantity;
                $totalPrice += $subtotal;

                // 5️⃣ Create pharmacy order item
                PharmacyOrderItem::create([
                    'pharmacy_order_id' => $pharmacyOrder->id,
                    'medicine_id' => $medicine->id ?? null,
                    'quantity' => $quantity,
                    'dosage' => $dosage,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);
            }

            // 6️⃣ Update total price and status
            $pharmacyOrder->update([
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);
        }
        /**
         * 💰 5. AUTO-BILLING LOGIC
         */
        if ($stage === 'billing') {

            // 🧭 Check if billing already exists
            $billing = $appointment->billing;

            $billingItems = [];
            $totalAmount = 0;

            // 🏥 1️⃣ TRIAGE (always exists, usually 0.00)
            $triageService = HospitalService::where('name', 'like', '%triage%')->first();
            if ($triageService) {
                $billingItems[] = [
                    'hospital_service_id' => $triageService->id,
                    'description' => $triageService->name,
                    'quantity' => 1,
                    'unit_price' => $triageService->price ?? 0,
                    'subtotal' => $triageService->price ?? 0,
                ];
                $totalAmount += $triageService->price ?? 0;
            }

            // 🩺 2️⃣ CONSULTATION
            $consultationService = HospitalService::where('name', 'like', '%consultation%')->first();
            if ($consultationService) {
                $billingItems[] = [
                    'hospital_service_id' => $consultationService->id,
                    'description' => $consultationService->name,
                    'quantity' => 1,
                    'unit_price' => $consultationService->price ?? 0,
                    'subtotal' => $consultationService->price ?? 0,
                ];
                $totalAmount += $consultationService->price ?? 0;
            }

            // 🧪 3️⃣ LAB TEST — handle multiple tests in one record
            if ($appointment->labTests && $appointment->labTests->count() > 0) {
                foreach ($appointment->labTests as $labTest) {
                    if ($labTest->status === 'completed') {

                        // Split test names by commas
                        $tests = array_map('trim', explode(',', $labTest->test_name));

                        foreach ($tests as $singleTest) {
                            if (empty($singleTest))
                                continue;

                            // 🔍 Find lab test price from lab_services
                            $labService = \App\Models\LabService::where('test_name', 'like', '%' . $singleTest . '%')->first();
                            $price = $labService->price ?? 0;

                            // 🏥 Ensure this lab test exists in hospital_services
                            $hospitalService = HospitalService::firstOrCreate(
                                ['name' => $singleTest, 'category' => 'Lab Test'],
                                ['price' => $price, 'description' => 'Automated sync from lab_services.']
                            );

                            // 💰 Add to billing items
                            $billingItems[] = [
                                'hospital_service_id' => $hospitalService->id,
                                'description' => $singleTest,
                                'quantity' => 1,
                                'unit_price' => $price,
                                'subtotal' => $price,
                            ];

                            $totalAmount += $price;
                        }
                    }
                }
            }



            // 💊 4️⃣ PHARMACY — only if any medicines exist
            if ($appointment->pharmacyOrder && $appointment->pharmacyOrder->items->count() > 0) {
                foreach ($appointment->pharmacyOrder->items as $phItem) {
                    $billingItems[] = [
                        'hospital_service_id' => null, // pharmacy is separate
                        'description' => $phItem->medicine->name ?? 'Medicine',
                        'quantity' => $phItem->quantity,
                        'unit_price' => $phItem->unit_price ?? 0,
                        'subtotal' => $phItem->subtotal ?? 0,
                    ];
                    $totalAmount += $phItem->subtotal ?? 0;
                }
            }

            // ✅ If billing does NOT exist, create one
            if (!$billing) {
                $billing = Billing::create([
                    'patient_id' => $appointment->patient_id,
                    'hospital_service_id' => $consultationService->id ?? null,
                    'amount' => $totalAmount,
                    'status' => 'unpaid',
                    'billable_id' => $appointment->id,
                    'billable_type' => Appointment::class,
                ]);

                foreach ($billingItems as $item) {
                    $billing->items()->create($item);
                }
            } else {
                // 🔄 Sync check: add any missing billing items (avoid duplicates)
                foreach ($billingItems as $item) {
                    $exists = $billing->items()
                        ->where('description', $item['description'])
                        ->exists();

                    if (!$exists) {
                        $billing->items()->create($item);
                    }
                }

                // 💵 Recalculate total
                $billing->update(['amount' => $billing->items->sum('subtotal')]);
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

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
            ]);
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
            'lab_technician' => ['lab', 'doctor_consult'],
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
