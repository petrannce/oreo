<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Medical;
use App\Models\Patient;
use DB;
use Illuminate\Http\Request;

class MedicalController extends Controller
{
    public function index()
    {
        $medical_records = Medical::with('patient')->latest()->get();
        return view('backend.medicals.index', compact('medical_records'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('backend.medicals.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'record_date' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
            'notes' => 'required',
        ]);

        DB::beginTransaction();
        
        try {
            $medical = new Medical();
            $medical->patient_id = $request->patient_id;
            $medical->record_date = $request->record_date;
            $medical->diagnosis = $request->diagnosis;
            $medical->prescription = $request->prescription;
            $medical->notes = $request->notes;
            $medical->save();
            DB::commit();
            return redirect()->route('medicals')->with('success', 'Medical record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
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
            'record_date' => 'required',
            'diagnosis' => 'required',
            'prescription' => 'required',
            'notes' => 'required',
        ]);

        DB::beginTransaction();
        
        try {
            $medical = Medical::findOrFail($id);
            $medical->patient_id = $request->patient_id;
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
