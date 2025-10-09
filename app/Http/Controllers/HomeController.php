<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\LabTest;
use App\Models\Triage;
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
        return view('backend.dashboard.receptionist', compact('appointments', 'contacts', 'doctors', 'patients'));
    }

    public function patients()
    {
        $appointments = DB::table('appointments')->get();
        $patients = DB::table('patients')->take(5)->get();
        return view('backend.dashboard.patient', compact('appointments', 'patients'));
    }

    public function nurses()
    {
        $today = now()->toDateString();
        return view('backend.dashboard.nurse', [
            'pending_triages' => Triage::whereNull('temperature')->with('patient', 'appointment')->latest()->get(),
            'pending_triages_count' => Triage::whereNull('temperature')->count(),
            'today_triages_count' => Triage::whereDate('created_at', $today)->count(),
            'completed_triages_count' => Triage::whereNotNull('temperature')->count(),
        ]);
    }

    public function pharmacists()
    {
        $pharmacy_order_items = DB::table('pharmacy_order_items')->get(); //pharmacy_order_items
        return view('backend.dashboard.pharmacist', compact('pharmacy_order_items'));
    }

    public function lab_technicians()
    {
        $userId = auth()->id();

        $pending_tests = LabTest::where('lab_technician_id', $userId)
            ->where('status', 'requested')
            ->get();

        $in_progress_tests = LabTest::where('lab_technician_id', $userId)
            ->where('status', 'in_progress')
            ->get();

        $completed_tests = LabTest::where('lab_technician_id', $userId)
            ->where('status', 'completed')
            ->get();

        $total_tests = LabTest::where('lab_technician_id', $userId)->get();
        return view('backend.dashboard.lab_technician', [
            'pending_tests' => $pending_tests,
            'in_progress_tests' => $in_progress_tests,
            'completed_tests' => $completed_tests,
            'total_tests' => $total_tests
        ]);
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
