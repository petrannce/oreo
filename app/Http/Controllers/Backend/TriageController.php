<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Triage;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;

class TriageController extends Controller
{
    public function index(Request $request)
    {
        $query = Triage::with(['patient', 'nurse', 'appointment']);

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $triages = $query->latest()->paginate(10);

        return view('backend.triages.index', [
            'triages' => $triages,
            'canExport' => true
        ]);
    }

    public function create(Request $request)
    {
        $appointmentId = $request->query('appointment_id');

        // Fetch the appointment and its patient
        $appointment = Appointment::with('patient')->findOrFail($appointmentId);

        // Get the logged-in nurse
        $loggedInNurseId = auth()->id();

        return view('backend.triages.create', [
            'appointment' => $appointment,
            'loggedInNurseId' => $loggedInNurseId,
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'nurse_id' => 'required|exists:users,id',
            'temperature' => 'required|numeric',
            'heart_rate' => 'required|integer',
            'blood_pressure' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            Triage::create([
                'patient_id' => $request->patient_id,
                'appointment_id' => $request->appointment_id,
                'nurse_id' => $request->nurse_id,
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'blood_pressure' => $request->blood_pressure,
                'weight' => $request->weight,
                'notes' => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('triages')->with('success', 'Triage record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('triages')->with('error', 'Triage record creation failed');
        }
    }

    public function show($id)
    {
        $triage = Triage::findOrFail($id);
        return view('backend.triages.show', compact('triage'));
    }

    public function edit($id)
    {
        $triage = Triage::findOrFail($id);
        return view('backend.triages.edit', compact('triage'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id',
            'nurse_id' => 'required|exists:nurses,id',
            'temperature' => 'required|numeric',
            'heart_rate' => 'required|integer',
            'blood_pressure' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $triage = Triage::findOrFail($id);
            $triage->update([
                'patient_id' => $request->patient_id,
                'appointment_id' => $request->appointment_id,
                'nurse_id' => $request->nurse_id,
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'blood_pressure' => $request->blood_pressure,
                'weight' => $request->weight,
                'notes' => $request->notes,
            ]);

            DB::commit();
            return redirect()->route('triages')->with('success', 'Triage record updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('triages')->with('error', 'Triage record update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('triages')->where('id', $id)->delete();
        return redirect()->route('triages')->with('success', 'Triage record deleted successfully');
    }

    public function report(Request $request)
    {
        // Same query logic as index
        $query = Triage::with(['patient', 'nurse', 'appointment']);

        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $data = $query->get();

        // Export as PDF (using dompdf / barryvdh/laravel-dompdf)
        $pdf = Pdf::loadView('backend.reports.triages', compact('data'));
        return $pdf->download('triages-report.pdf');
    }
}
