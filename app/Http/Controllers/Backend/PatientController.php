<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Patient;
use DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('backend.patients.index', compact('patients'));
    }

    public function create()
    {
        $users = User::where('role', 'patient')
        ->whereDoesntHave('patient')
        ->get();
        return view('backend.patients.create',compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'dob' => 'required',
        ]);
        DB::beginTransaction();

        try {

            // Get last patient entry
            $lastPatient = Patient::whereNotNull('medical_record_number')
                ->orderBy('id', 'desc')
                ->select('medical_record_number')
                ->first();

            // Generate new employee code if not provided
            if($lastPatient && preg_match('/(\d+)$/', $lastPatient->medical_record_number, $m)) {
                $nextNumber = intval($m[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $medical_record_number = 'MRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            while(Patient::where('medical_record_number', $medical_record_number)->exists()) {
                $nextNumber++;
                $medical_record_number = 'MRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $finalcode = $request->medical_record_number ?? $medical_record_number;

            Patient::create([
                'user_id' => $request->user_id,
                'medical_record_number' => $finalcode,
                'dob' => $request->dob,
            ]);

            DB::commit();
            return redirect()->route('patients')->with('success', 'Patient created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('patients')->with('error', 'Patient creation failed');
        }
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('backend.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'required',
            'medical_record_number' => 'required',
            'dob' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $patient = Patient::findOrFail($id);

            $patient->user_id = $request->user_id;
            $patient->medical_record_number = $request->medical_record_number;
            $patient->dob = $request->dob;

            $patient->save();
            
            DB::commit();
            return redirect()->route('patients')->with('success', 'Patient updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->route('patients')->with('error', 'Patient update failed');
        }
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('backend.patients.show', compact('patient'));
    }

    public function destroy($id)
    {
        DB::table('patients')->where('id', $id)->delete();
        return redirect()->route('patients')->with('success', 'Patient deleted successfully');
    }


}
