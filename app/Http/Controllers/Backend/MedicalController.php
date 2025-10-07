<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class MedicalController extends Controller
{
    public function index()
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

        return view('backend.medicals.index', [
            'medical_records' => $medical_records,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('backend.medicals.create', compact('patients'));
    }

    public function store(Request $request)
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
            $medical = new Medical();
            $medical->patient_id = $request->patient_id;
            $medical->doctor_id = $request->doctor_id;
            $medical->record_date = $request->record_date;
            $medical->diagnosis = $request->diagnosis;
            $medical->prescription = $request->prescription;
            $medical->notes = $request->notes;

            $medical->save();

            DB::commit();
            return redirect()->route('medicals')->with('success', 'Medical record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
           dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->route('medicals')->with('error', 'Medical record creation failed');
        }
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
}
