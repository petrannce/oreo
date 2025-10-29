<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\LabService;
use App\Models\LabTest;
use App\Models\Medical;
use DB;
use Illuminate\Http\Request;

class MedicalController extends Controller
{
    public function index()
    {
        $medical_records = Medical::with('patient', 'doctor')->get();

        return view('backend.medicals.index', [
            'medical_records' => $medical_records,
        ]);
    }

    public function create(Request $request)
    {
        $appointment_id = $request->appointment_id;

        if ($appointment_id) {
            $appointment = Appointment::with('patient', 'triage', 'LabTests')->find($appointment_id);
        }

        $lab_tests = LabService::all();

        return view('backend.medicals.create', compact('appointment', 'lab_tests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
            'record_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        $medicalRecord = Medical::create($validated);

        // Optionally update appointment stage
        if ($medicalRecord->appointment_id) {
            $medicalRecord->appointment->update(['process_stage' => 'lab']);
        }

        return redirect()->route('appointments')->with('success', 'Medical record created successfully!');
    }


    public function edit($id)
    {
        $medical_record = Medical::findOrFail($id);
        return view('backend.medicals.edit', compact('medical_record'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'record_date' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
            'notes' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $medical = Medical::findOrFail($id);
            $medical->patient_id = $request->patient_id;
            $medical->doctor_id = $request->doctor_id;
            $medical->record_date = $request->record_date;
            $medical->diagnosis = $request->diagnosis;
            $medical->prescription = $request->prescription;
            $medical->notes = $request->notes;
            $medical->save();
            DB::commit();
            return redirect()->route('medicals')->with('success', 'Medical record updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('medicals')->with('error', 'Medical record update failed');
        }
    }

    public function show($id)
    {
        $medical_record = Medical::findOrFail($id);
        $appointment = Appointment::where('patient_id', $medical_record->patient_id)->first();
        return view('backend.medicals.view', compact('medical_record', 'appointment'));
    }

    public function destroy($id)
    {
        DB::table('medical_records')->where('id', $id)->delete();
        return redirect()->route('medicals')->with('success', 'Medical record deleted successfully');
    }

    public function report()
    {
        // Start query — don't call get() yet
        $query = Medical::with(['patient', 'doctor']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $medical_records = $query->latest()->paginate(10);

        return view('backend.medicals.reports', [
            'medical_records' => $medical_records,
            'canExport' => true
        ]);
    }
}
