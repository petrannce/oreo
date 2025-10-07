<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
     use App\Models\LabTechnician;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\Http\Request;
use DB;

class LabTestController extends Controller
{
    public function index()
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

        $lab_tests = $query->latest()->paginate(10);

        return view('backend.lab_tests.index', [
            'lab_tests' => $lab_tests,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $lab_technicians = LabTechnician::all();
        return view('backend.lab_tests.create', compact('patients', 'doctors', 'lab_technicians'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'lab_technician_id' => 'required|exists:lab_technicians,id',
                'appointment_id' => 'required|exists:appointments,id',
                'test_name' => 'required|string|max:255',
                'results' => 'nullable|string',
                'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            LabTest::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => $request->doctor_id,
                'lab_technician_id' => $request->lab_technician_id,
                'appointment_id' => $request->appointment_id,
                'test_name' => $request->test_name,
                'results' => $request->results,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('lab_tests')->with('success', 'Lab Test created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('lab_tests')->with('error', 'Lab Test creation failed');
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
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'lab_technician_id' => 'required|exists:lab_technicians,id',
                'appointment_id' => 'required|exists:appointments,id',
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

    public function destroy($id)
    {
        DB::table('lab_tests')->where('id', $id)->delete();
        return redirect()->route('lab_tests')->with('success', 'Lab Test deleted successfully');
    }
}
