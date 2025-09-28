<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
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
        $appointments = Appointment::with(['patient', 'doctor', 'service'])->get();
        return view('backend.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = User::where('role', 'patient')->get();
        $services = Service::all();
        $doctors = User::where('role', 'doctor')->get();
        return view('backend.appointments.create',compact('patients','services','doctors'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'booked_by' => 'required',
            'date' => 'required',
            'time' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $appointment = new Appointment();
            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->service_id = $request->service_id;
            $appointment->booked_by = $request->booked_by;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->status = 'pending';
            
            $appointment->save();
            
            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error
        //dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Appointment creation failed');
        }
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $services = Service::all();
        $doctors = User::where('role', 'doctor')->get();
        return view('backend.appointments.edit', compact('appointment', 'services', 'doctors'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'service_id' => 'required',
            'booked_by' => 'required',
            'date' => 'required',
            'time' => 'required',
            
        ]);

        DB::beginTransaction();
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->patient_id = $request->patient_id;
            $appointment->doctor_id = $request->doctor_id;
            $appointment->service_id = $request->service_id;
            $appointment->booked_by = $request->booked_by;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->status = 'pending';
            $appointment->save();
            
            DB::commit();
            return redirect()->route('appointments')->with('success', 'Appointment updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
            return redirect()->back()->with('error', 'Appointment update failed');
        }
    }

    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
        return view('backend.appointments.view', compact('appointment'));
    }

    public function destroy($id)
    {
        DB::table('appointments')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Appointment deleted successfully');
    }

    public function updateStatus($id, $status)
    {
        $appointment = Appointment::findOrFail($id);
        $validStatuses = ['approved', 'pending', 'cancelled'];

        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Invalid status selected');
        }

        $appointment->status = $status;
        $appointment->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}
