<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\BillingItem;
use App\Models\LabTest;
use App\Models\PharmacyOrderItem;
use App\Models\Triage;
use Illuminate\Support\Facades\DB;
use App\Models\Subscriber;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;

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

        $today_triages_count = Triage::whereDate('created_at', $today)->count();
        $pending_triages = Appointment::whereDoesntHave('triage')
            ->with('patient')
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();
        $pending_triages_count = $pending_triages->count();
        $completed_triages_count = Triage::count();

        $average_temp = Triage::whereDate('created_at', $today)->avg('temperature');
        $average_weight = Triage::whereDate('created_at', $today)->avg('weight');
        $common_bp = Triage::whereDate('created_at', $today)
            ->select('blood_pressure')
            ->groupBy('blood_pressure')
            ->orderByRaw('COUNT(*) DESC')
            ->value('blood_pressure');
        $common_hr = Triage::whereDate('created_at', $today)
            ->select('heart_rate')
            ->groupBy('heart_rate')
            ->orderByRaw('COUNT(*) DESC')
            ->value('heart_rate');

        return view('backend.dashboard.nurse', [
            'today_triages_count' => $today_triages_count,
            'pending_triages' => $pending_triages,
            'pending_triages_count' => $pending_triages_count,
            'completed_triages_count' => $completed_triages_count,
            'average_temp' => $average_temp,
            'average_weight' => $average_weight,
            'common_bp' => $common_bp,
            'common_hr' => $common_hr
        ]);
    }

    public function pharmacists()
    {

        $pharmacy_order_items = PharmacyOrderItem::with('patient')
            ->latest()
            ->take(8)
            ->get();

        return view('backend.dashboard.pharmacist', compact('pharmacy_order_items'));
    }

    public function accountant()
    {

        $totalRevenue = Billing::where('status', 'paid')->sum('amount');
        $unpaidBills = Billing::where('status', 'unpaid')->count();
        $paidBills = Billing::where('status', 'paid')->count();
        $cancelledBills = Billing::where('status', 'cancelled')->count();

        $revenueTrend = Billing::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('total', 'month');

        $topServices = BillingItem::select('hospital_service_id', DB::raw('SUM(subtotal) as total'))
            ->groupBy('hospital_service_id')
            ->with('hospitalService')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $recentTransactions = Billing::with('patient')
            ->latest()
            ->take(5)
            ->get();

        $outstandingTotal = Billing::where('status', 'unpaid')->sum('amount');

        return view('backend.dashboard.accountant', [
            'totalRevenue' => $totalRevenue,
            'unpaidBills' => $unpaidBills,
            'paidBills' => $paidBills,
            'cancelledBills' => $cancelledBills,
            'revenueTrend' => $revenueTrend,
            'topServices' => $topServices,
            'recentTransactions' => $recentTransactions,
            'outstandingTotal' => $outstandingTotal
        ]);
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
