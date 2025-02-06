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
        $patients = DB::table('patients')->get();
        return view('backend.dashboard.doctor', compact('doctors', 'appointments', 'patients'));
    }

    public function receptionists()
    {
        $appointments = DB::table('appointments')->get();
        $contacts = DB::table('contacts')->get();
        return view('backend.dashboard.receptionist', compact( 'appointments', 'contacts'));
    }

    public function patients()
    {
        $appointments = DB::table('appointments')->get();
        return view('backend.dashboard.patient', compact( 'appointments'));
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
