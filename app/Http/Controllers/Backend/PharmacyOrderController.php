<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PharmacyOrder;
use DB;
use Illuminate\Http\Request;

class PharmacyOrderController extends Controller
{
    public function index()
    {
        // Start query — don't call get() yet
        $query = PharmacyOrder::with(['patient', 'doctor']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $pharmacy_orders = $query->latest()->paginate(10);

        return view('backend.pharmacy_orders.index', [
            'pharmacy_orders' => $pharmacy_orders,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('backend.pharmacy_orders.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medical_record_id' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $pharmacy_order = new PharmacyOrder();
            $pharmacy_order->patient_id = $request->patient_id;
            $pharmacy_order->doctor_id = $request->doctor_id;
            $pharmacy_order->medical_record_id = $request->medical_record_id;
            $pharmacy_order->status = $request->status;
            $pharmacy_order->save();

            DB::commit();
            return redirect()->route('pharmacy_orders.index')->with('success', 'Pharmacy Order created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pharmacy_orders.index')->with('error', 'Failed to create Pharmacy Order');
        }
    }

    public function edit($id)
    {
        $pharmacy_order = PharmacyOrder::findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('backend.pharmacy_orders.edit', compact('pharmacy_order', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medical_record_id' => 'required|string',
            'status' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $pharmacy_order = PharmacyOrder::findOrFail($id);
            $pharmacy_order->patient_id = $request->patient_id;
            $pharmacy_order->doctor_id = $request->doctor_id;
            $pharmacy_order->medical_record_id = $request->medical_record_id;
            $pharmacy_order->status = $request->status;
            $pharmacy_order->save();

            DB::commit();
            return redirect()->route('pharmacy_orders')->with('success', 'Pharmacy Order updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pharmacy_orders')->with('error', 'Failed to update Pharmacy Order');
        }
    }

    public function destroy($id)
    {
        DB::table('pharmacy_orders')->where('id', $id)->first();
        return redirect()->route('pharmacy_orders')->with('success', 'Pharmacy Order deleted successfully');

    }
}
