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
        $triages = Triage::with(['patient', 'nurse', 'appointment'])->latest()->paginate(10);

        return view('backend.triages.index', [
            'triages' => $triages,
        ]);
    }

    public function create(Appointment $appointment, $appointment_id)
    {
        // Get the appointment and related patient
        $appointment = Appointment::with('patient', 'doctor', 'service')->findOrFail($appointment_id);

        // Logged-in nurse ID (must be authenticated as nurse)
        $loggedInNurseId = auth()->id();

        // Optionally, confirm the user has nurse role
        if (!auth()->user()->hasAnyRole(['nurse', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('backend.triages.create', [
            'appointment' => $appointment,
            'loggedInNurseId' => $loggedInNurseId,
        ]);
    }


    public function store(Request $request)
    { {
            $request->validate([
                'patient_id' => 'required|exists:users,id',
                'appointment_id' => 'required|exists:appointments,id',
                'nurse_id' => 'required|exists:users,id',
                'temperature' => 'nullable|numeric',
                'heart_rate' => 'nullable|string|max:255',
                'blood_pressure' => 'nullable|string|max:255',
                'weight' => 'nullable|numeric',
                'notes' => 'nullable|string',
            ]);

            // Save Triage
            $triage = Triage::create($request->only([
                'patient_id',
                'appointment_id',
                'nurse_id',
                'temperature',
                'heart_rate',
                'blood_pressure',
                'weight',
                'notes'
            ]));

            return redirect()->route('appointments')
                ->with('triage', $triage)
                ->with('success', 'Triage created successfully.');
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
        $query = Triage::with(['patient', 'nurse', 'appointment']);

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $triages = $query->latest()->paginate(10);

        return view('backend.triages.reports', [
            'triages' => $triages,
            'canExport' => true
        ]);
    }
}
