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
        return view('backend.dashboard.admin', compact('patients', 'doctors', 'users', 'appointments', 'contacts'));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        $appointments = DB::table('appointments')->get();
        return view('backend.dashboard.doctor', compact('doctors', 'appointments'));
    }

    public function receptionists()
    {
        $appointments = DB::table('appointments')->get();
        $contacts = DB::table('contacts')->get();
        return view('backend.dashboard.receptionist', compact( 'appointments', 'contacts'));
    }

    public function patients()
    {
        $user = Auth::user(); // Get the currently authenticated user

    // Check if the user has the 'patient' role
    if ($user->role === 'patient') {
        $appointments = Appointment::whereHas('patient', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    } else {
        $appointments = collect(); // Empty collection for non-patients
    }

        return view('backend.dashboard.patient', compact( 'appointments', 'pendingAppointments'));
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
