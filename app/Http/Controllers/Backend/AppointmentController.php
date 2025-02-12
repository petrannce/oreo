<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Appointment;
use DB;
use App\Models\Service;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = DB::table('appointments')
        ->join('patients', 'appointments.patient_id', '=', 'patients.id')
        ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
        ->join('users', 'appointments.booked_by', '=', 'users.id')
        ->select('appointments.*', 
        'patients.fname as patient_fname', 'patients.lname as patient_lname', 
        'doctors.fname as doctor_fname', 'doctors.lname as doctor_lname',
        'users.fname as user_fname', 'users.lname as user_lname'
        )
        ->get();
        return view('backend.appointments.index',compact('appointments'));
    }

    public function create()
    {
        $services = Service::all();
        $doctors = Doctor::all();
        $patients = Patient::all();
        return view('backend.appointments.create',compact('services','doctors','patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'service' => 'required',
            'doctor_id' => 'required',
        ]);

        $bookedBy = Auth::user();

        DB::beginTransaction();
        try {
            $appointment = new Appointment();
            $appointment->patient_id = $request->patient_id;
            $appointment->booked_by = $bookedBy->id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->service = $request->service;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->status = 'pending';
            $appointment->save();
            
            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Appointment creation failed');
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $services = Service::all();
        $doctors = Doctor::all();
        $appointments = DB::table('appointments')
        ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
        ->select('appointments.*', 'doctors.fname as doctor_fname', 'doctors.lname as doctor_lname')
        ->get();
        return view('backend.appointments.edit', compact('appointment','services','doctors'));
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'patient_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'service' => 'required',
            'doctor_id' => 'required',
        ]);

        $bookedBy = Auth::user();

        DB::beginTransaction();
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->patient_id = $request->patient_id;
            $appointment->booked_by = $bookedBy->id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->service = $request->service;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->status = 'pending';
            $appointment->save();
            
            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Appointment update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('appointments')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully');
    }
}
