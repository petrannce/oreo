<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabRequirement;
use App\Models\LabService;
use App\Models\LabTest;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class LabTestController extends Controller
{
    public function index()
    {

        $lab_tests = LabTest::with(['patient', 'doctor', 'lab_technician', 'appointment'])->latest()->get();

        return view('backend.lab_tests.index', [
            'lab_tests' => $lab_tests,
        ]);
    }

    public function create($appointment_id = null)
    {
        $user = auth()->user();
        $selectedAppointment = null;

        if ($appointment_id) {
            // load appointment with patient/doctor
            $selectedAppointment = Appointment::with(['patient', 'doctor', 'labRequirements'])->find($appointment_id);
            if (!$selectedAppointment) {
                return redirect()->route('lab_tests.create')->with('error', 'Appointment not found.');
            }
        }

        // Role-based lists (kept broad so prefill always shows correct record)
        if ($user->role === 'admin') {
            $patients = User::where('role', 'patient')->get();
            $doctors = User::where('role', 'doctor')->get();
            $lab_technicians = User::where('role', 'lab_technician')->get();
            $appointments = Appointment::with(['patient', 'doctor'])->latest()->get();
        } elseif ($user->role === 'lab_technician') {
            // lab tech sees all patients/doctors but technician field will auto-assign to auth
            $patients = User::where('role', 'patient')->get();
            $doctors = User::where('role', 'doctor')->get();
            $lab_technicians = collect([$user]); // only themselves
            $appointments = Appointment::with(['patient', 'doctor'])->latest()->get();
        } elseif ($user->role === 'doctor') {
            $patients = User::whereHas('appointments', function ($q) use ($user) {
                $q->where('doctor_id', $user->id);
            })->get();
            $doctors = collect([$user]);
            $lab_technicians = User::where('role', 'lab_technician')->get();
            $appointments = Appointment::where('doctor_id', $user->id)->with('patient')->latest()->get();
        } else {
            $patients = collect();
            $doctors = collect();
            $lab_technicians = collect();
            $appointments = collect();
        }

        // Ensure selected patient/doctor are present in the collections so dropdowns can use them if needed
        if ($selectedAppointment) {
            if ($patients->isEmpty() || !$patients->contains('id', $selectedAppointment->patient_id)) {
                $patients->push($selectedAppointment->patient);
            }
            if ($doctors->isEmpty() || !$doctors->contains('id', $selectedAppointment->doctor_id)) {
                $doctors->push($selectedAppointment->doctor);
            }
        }

        return view('backend.lab_tests.create', compact(
            'patients',
            'doctors',
            'lab_technicians',
            'appointments',
            'selectedAppointment'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'lab_technician_id' => 'nullable|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'test_name' => 'required|string|max:255',
            'results' => 'nullable|string',
            'status' => 'required|in:requested,in_progress,completed',
        ]);

        DB::beginTransaction();

        try {
            LabTest::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'lab_technician_id' => $request->lab_technician_id ?? auth()->id(), // auto-assign logged-in tech
                'appointment_id' => $request->appointment_id,
                'test_name' => $request->test_name,
                'results' => $request->results,
                'status' => $request->status,
            ]);

            // Optional: update appointment process stage to 'lab' if linked
            if ($request->filled('appointment_id')) {
                Appointment::where('id', $request->appointment_id)
                    ->update(['process_stage' => 'lab']);
            }

            DB::commit();

            return redirect()->route('appointments')
                ->with('success', 'Lab Test created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('lab_tests')
                ->with('error', 'Lab Test creation failed: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $lab_test = LabTest::findOrFail($id);
        return view('backend.lab_tests.edit', compact('lab_test'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'lab_technician_id' => 'required',
            'appointment_id' => 'required',
            'test_name' => 'required|string|max:255',
            'results' => 'nullable|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $lab_test = LabTest::findOrFail($id);
            $lab_test->update([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'lab_technician_id' => $request->lab_technician_id,
                'appointment_id' => $request->appointment_id,
                'test_name' => $request->test_name,
                'results' => $request->results,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('lab_tests')->with('success', 'Lab Test updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('lab_tests')->with('error', 'Lab Test update failed');
        }
    }

    public function show($id)
    {
        $lab_test = LabTest::findOrFail($id);
        return view('backend.lab_tests.view', compact('lab_test'));
    }

    public function destroy($id)
    {
        DB::table('lab_tests')->where('id', $id)->delete();
        return redirect()->route('lab_tests')->with('success', 'Lab Test deleted successfully');
    }

    public function report()
    {
        // Start query — don't call get() yet
        $query = LabTest::with(['patient', 'doctor', 'lab_technician', 'appointment']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $lab_tests = $query->latest()->get();

        return view('backend.lab_tests.reports', [
            'lab_tests' => $lab_tests,
            'canExport' => true
        ]);
    }

    public function createForAppointment(Request $request, Appointment $appointment)
    {
        // Prevent duplicate assignment
        if ($appointment->labRequirements && $appointment->labRequirements->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'This appointment already has lab test(s) assigned.'
            ], 400);
        }

        // Validate input
        $request->validate([
            'lab_tests' => 'required|array|min:1',
            'lab_tests.*' => 'exists:lab_services,id',
        ]);

        try {
            DB::beginTransaction();

            // Save selected lab services into lab_requirements
            foreach ($request->lab_tests as $serviceId) {
                $service = LabService::find($serviceId);

                LabRequirement::create([
                    'appointment_id' => $appointment->id,
                    'name' => $service->test_name,
                    // Optional: Store price for quicker billing reference
                    // 'price' => $service->price,
                ]);
            }

            // Update appointment process stage to lab
            $appointment->update(['process_stage' => 'lab']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Lab tests successfully assigned and appointment sent to lab.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send to lab: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showByAppointment($appointment_id)
    {
        $lab_tests = LabTest::where('appointment_id', $appointment_id)->get();

        if ($lab_tests->isEmpty()) {
            abort(404, 'No lab tests found for this appointment.');
        }

        $lab_test = $lab_tests->first();

        return view('backend.lab_tests.view', compact('lab_tests', 'lab_test'));
    }



}
