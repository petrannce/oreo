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

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
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
        //dd($request->all());
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

            return redirect()->route('appointments.index')->with('success', 'Appointment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Appointment creation failed');
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('backend.appointments.edit', compact('appointment'));
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
            return redirect()->back()->with('success', 'Appointment updated successfully');
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
