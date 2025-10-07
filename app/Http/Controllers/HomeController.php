<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Subscriber;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $users = User::all();
        $appointments = DB::table('appointments')->get();
        $contacts = DB::table('contacts')->get();
        $resources = DB::table('resources')->get();
        return view('backend.dashboard.admin', compact('patients', 'doctors', 'users', 'appointments', 'contacts', 'resources'));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        $appointments = DB::table('appointments')->get();
        $patients = Patient::with('user')->get();
        return view('backend.dashboard.doctor', compact('doctors', 'appointments', 'patients'));
    }

    public function receptionists()
    {
        $doctors = Doctor::all();
        $appointments = DB::table('appointments')->get();
        $patients = Patient::with('user')->get();
        $contacts = DB::table('contacts')->get();
        return view('backend.dashboard.receptionist', compact( 'appointments', 'contacts', 'doctors', 'patients'));
    }

    public function patients()
    {
        $appointments = DB::table('appointments')->get();
        $patients = DB::table('patients')->take(5)->get();
        return view('backend.dashboard.patient', compact( 'appointments', 'patients'));
    }

    public function nurses()
    {
        $triages = DB::table('triages')->get();
        return view('backend.dashboard.nurse', compact('triages'));
    }

    public function pharmacists()
    {
        $pharmacy_order_items = DB::table('pharmacy_order_items')->get(); //pharmacy_order_items
        return view('backend.dashboard.pharmacist', compact('pharmacy_order_items'));
    }

    public function lab_technicians()
    {
        $lab_tests = DB::table('lab_tests')->get();
        return view('backend.dashboard.lab_technician', compact('lab_tests'));
    }

    public function subscribers()
    {
        $subscribers = Subscriber::all();
        return view('backend.subscribers.index', compact('subscribers'));
    }

    public function subscribersDestroy($id)
    {
        DB::table('subscribers')->where('id', $id)->delete();
        return redirect()->route('subscribers')->with('success', 'Subscriber deleted successfully');
    }
}
