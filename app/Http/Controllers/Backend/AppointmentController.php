<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use DB;
use App\Models\Service;
use App\Models\Doctor;

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
        return view('backend.appointments.create',compact('services','doctors'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'service' => 'required',
            'doctor' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $appointment = new Appointment();
            $appointment->user_id = $request->user_id;
            $appointment->date = $request->date;
            $appointment->time = $request->time;
            $appointment->service = $request->service;
            $appointment->doctor = $request->doctor;
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
            'user_id' => 'required',
            'gender' => 'required',
            'service' => 'required',
            'date' => 'required',
            'department' => 'required',
            'doctor' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->user_id = $request->user_id;
            $appointment->gender = $request->gender;
            $appointment->service = $request->service;
            $appointment->date = $request->date;
            $appointment->department = $request->department;
            $appointment->doctor = $request->doctor;
            $appointment->message = $request->message;
            $appointment->status = $request->status;
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
