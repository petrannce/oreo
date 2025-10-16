<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PharmacyOrder;
use DB;
use Illuminate\Http\Request;

class PharmacyOrderController extends Controller
{
    public function index()
    {
        $pharmacy_orders = PharmacyOrder::with(['doctor', 'patient'])->get();

        return view('backend.pharmacy_orders.index', [
            'pharmacy_orders' => $pharmacy_orders,
        ]);
    }

    public function create($appointment_id = null)
    {
        $appointment = null;

        if ($appointment_id) {
            $appointment = Appointment::with(['patient', 'doctor'])->find($appointment_id);
        }

        return view('backend.pharmacy_orders.create', [
            'appointment' => $appointment,
            'patients' => Patient::all(),
            'doctors' => Doctor::all(),
            'appointments' => Appointment::with(['patient'])->get(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'status' => 'required|in:pending,billed,dispensed',
        ]);

        DB::beginTransaction();

        try {
            // Fetch related appointment
            $appointment = Appointment::with(['patient', 'doctor', 'medicalRecord'])
                ->findOrFail($request->appointment_id);

            $order = new PharmacyOrder();
            $order->appointment_id = $appointment->id;
            $order->patient_id = $appointment->patient_id;
            $order->doctor_id = $appointment->doctor_id;
            $order->medical_record_id = $appointment->medicalRecord->id ?? null;
            $order->status = $request->status ?? 'pending';

            $order->save();

            DB::commit();

            return redirect()
                ->route('pharmacy_orders')
                ->with('success', 'Pharmacy order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pharmacy_order = PharmacyOrder::findOrFail($id);

        // Fetch all prescriptions for this appointment, ordered by creation date
        $prescriptions = $pharmacy_order->appointment
            ->medicalRecords()
            ->orderBy('created_at')
            ->pluck('prescription')
            ->filter()
            ->values();

        $prescriptionText = $prescriptions->map(function ($item, $key) {
            return ($key + 1) . ". " . $item;
        })->implode("\n");

        return view('backend.pharmacy_orders.edit', compact(
            'pharmacy_order',
            'prescriptionText'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_id' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'medical_record_id' => 'nullable',
            'total_price' => 'required',
            'status' => 'required|in:pending,billed,dispensed,finalised',
        ]);

        DB::beginTransaction();

        try {
            $order = PharmacyOrder::findOrFail($id);

            $order->appointment_id = $request->appointment_id;
            $order->patient_id = $request->patient_id;
            $order->doctor_id = $request->doctor_id;
            $order->medical_record_id = $request->medical_record_id;
            $order->total_price = $request->total_price;
            $order->status = $request->status;

            $order->save();

            DB::commit();

            return redirect()
                ->route('appointments')
                ->with('success', 'Pharmacy order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pharmacy_order = PharmacyOrder::findOrFail($id);
        return view('backend.pharmacy_orders.view', compact('pharmacy_order'));
    }

    public function destroy($id)
    {
        DB::table('pharmacy_orders')->where('id', $id)->first();
        return redirect()->route('pharmacy_orders')->with('success', 'Pharmacy Order deleted successfully');

    }

    public function report()
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

        return view('backend.pharmacy_orders.reports', [
            'pharmacy_orders' => $pharmacy_orders,
            'canExport' => true
        ]);
    }


}
