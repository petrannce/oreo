<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use DB;
use function Laravel\Prompts\table;

class PatientController extends Controller
{
    public function index()
    {
        return view('backend.patients.index');
    }

    public function create()
    {
        return view('backend.patients.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'patient_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required|nullable',
        ]);

        DB::beginTransaction();

        try {
            $patient = new Patient();
            $patient->patient_id = $request->patient_id;
            $patient->fname = $request->fname;
            $patient->lname = $request->lname;
            $patient->email = $request->email;
            $patient->phone = $request->phone;
            $patient->gender = $request->gender;
            $patient->age = $request->age;
            $patient->address = $request->address;
            $patient->save();
            DB::commit();
            return redirect()->route('patients')->with('success', 'Patient created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('patients')->with('error', 'Patient creation failed');
        }
    }

    public function edit($id)
    {
        $patient = Patient::find($id);
        return view('backend.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $request -> validate([
            'patient_id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:patients,email,'.$id,
            'phone' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required|nullable',
        ]);

        DB::beginTransaction();

        try {
            $patient = Patient::find($id);
            $patient->patient_id = $request->patient_id;
            $patient->fname = $request->fname;
            $patient->lname = $request->lname;
            $patient->email = $request->email;
            $patient->phone = $request->phone;
            $patient->gender = $request->gender;
            $patient->age = $request->age;
            $patient->address = $request->address;
            $patient->save();
            DB::commit();
            return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('patients.index')->with('error', 'Patient update failed');
        }
    }

    public function destroy($id)
    {
       DB::table('patients')->where('id', $id)->delete();
       return redirect()->route('patients')->with('success', 'Patient deleted successfully');
    }
}
