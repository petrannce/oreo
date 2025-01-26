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
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
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
            $appointment = new Appointment();
            $appointment->fname = $request->fname;
            $appointment->lname = $request->lname;
            $appointment->email = $request->email;
            $appointment->phone = $request->phone;
            $appointment->gender = $request->gender;
            $appointment->service = $request->service;
            $appointment->date = $request->date;
            $appointment->department = $request->department;
            $appointment->doctor = $request->doctor;
            $appointment->message = $request->message;
            $appointment->status = $request->status;
            $appointment->save();
            DB::commit();
            return redirect()->back()->with('success', 'Appointment created successfully');
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
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
            $appointment->fname = $request->fname;
            $appointment->lname = $request->lname;
            $appointment->email = $request->email;
            $appointment->phone = $request->phone;
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
