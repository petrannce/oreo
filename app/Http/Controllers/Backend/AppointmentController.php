<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
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
        return view('backend.appointments.create',[
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
    public function updateStage($id, $stage)
    {
        $appointment = Appointment::findOrFail($id);

        // All valid stages in your workflow
        $validStages = [
            'reception',        // Appointment booked / pending check-in
            'triage',           // Nurse evaluating vitals
            'doctor_consult',   // Doctor consultation
            'lab',              // Lab tests ordered
            'pharmacy',         // Pharmacy dispensing
            'billing',          // Billing/payment processing
            'completed',        // Fully completed process
            'cancelled',        // Cancelled appointment
        ];

        if (!in_array($stage, $validStages)) {
            return back()->with('error', 'Invalid stage selected.');
        }

        // Get logged-in user’s role
        $user = Auth::user();
        $userRole = $user->role ?? null;

        // Define role-based permissions
        $rolePermissions = [
            'receptionist' => ['reception', 'triage', 'cancelled'],
            'nurse' => ['triage', 'doctor_consult'],
            'doctor' => ['doctor_consult', 'lab', 'pharmacy', 'billing', 'completed'],
            'lab_technician' => ['lab'],
            'pharmacist' => ['pharmacy', 'billing', 'completed'],
            'admin' => $validStages,
        ];

        // Permission check
        if (!isset($rolePermissions[$userRole]) || !in_array($stage, $rolePermissions[$userRole])) {
            return back()->with('error', 'You do not have permission to move a patient to this stage.');
        }

        // Check if already in the desired stage
        if ($appointment->process_stage === $stage) {
            return back()->with('info', 'Patient is already in this stage.');
        }

        // Update stage
        $appointment->process_stage = $stage;
        $appointment->save();

        // Dynamic user-friendly message
        $message = 'Patient moved to ' . ucfirst(str_replace('_', ' ', $stage)) . ' stage successfully.';

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


}
