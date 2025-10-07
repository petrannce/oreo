<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Patient;
use Illuminate\Http\Request;
use DB;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $billings = Billing::all();
        //start query - don't call get() yet
        $query = Billing::with(['patient']);

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $billings = $query->latest()->paginate(10);

        return view('backend.billings.index', [
            'billings' => $billings,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        return view('backend.billings.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'billable_type' => 'required|string',
            'billable_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            
            Billing::create([
                'patient_id' => $request->patient_id,
                'billable_type' => $request->billable_type,
                'billable_id' => $request->billable_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
            ]);

            DB::commit();
            return redirect()->route('billings')->with('success', 'Billing created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('billings')->with('error', 'Billing creation failed');
        }
    }

    public function edit($id)
    {
        $billing = Billing::findOrFail($id);
        return view('backend.billings.edit', compact('billing'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'billable_type' => 'required|string',
            'billable_id' => 'required|integer',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $billing = Billing::findOrFail($id);

            $billing->update([
                'patient_id' => $request->patient_id,
                'billable_type' => $request->billable_type,
                'billable_id' => $request->billable_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
            ]);
            
            DB::commit();
            return redirect()->route('billings')->with('success', 'Billing updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('billings')->with('error', 'Billing update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('billings')->where('id', $id)->delete();
        return redirect()->route('billings')->with('success', 'Billing deleted successfully');
    }
}
