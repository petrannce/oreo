<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('backend.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('backend.patients.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'dob' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $patient = new Patient();
            $patient->fname = $request->fname;
            $patient->lname = $request->lname;
            $patient->email = $request->email;
            $patient->phone_number = $request->phone_number;
            $patient->address = $request->address;
            $patient->city = $request->city;
            $patient->country = $request->country;
            $patient->gender = $request->gender;
            $patient->DOB = $request->DOB;
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
        $patient = Patient::findOrFail($id);
        return view('backend.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'gender' => 'required',
            'dob' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $patient = Patient::findOrFail($id);
            $patient->fname = $request->fname;
            $patient->lname = $request->lname;
            $patient->email = $request->email;
            $patient->phone_number = $request->phone_number;
            $patient->address = $request->address;
            $patient->city = $request->city;
            $patient->country = $request->country;
            $patient->gender = $request->gender;
            $patient->DOB = $request->DOB;
            $patient->save();
            
            DB::commit();
            return redirect()->route('patients')->with('success', 'Patient updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
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
