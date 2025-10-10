<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();

        return view('backend.patients.index', [
            'patients' => $patients,
        ]);
    }

    public function create()
    {
        // No need to fetch users since patients are not users
        return view('backend.patients.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'email' => 'nullable|email|unique:patients,email',
            'phone_number' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction();

        try {
            // Get last MRN
            $lastPatient = Patient::whereNotNull('medical_record_number')
                ->orderBy('id', 'desc')
                ->select('medical_record_number')
                ->first();

            if ($lastPatient && preg_match('/(\d+)$/', $lastPatient->medical_record_number, $m)) {
                $nextNumber = intval($m[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $medical_record_number = 'MRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Ensure MRN uniqueness
            while (Patient::where('medical_record_number', $medical_record_number)->exists()) {
                $nextNumber++;
                $medical_record_number = 'MRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            // Create patient
            Patient::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'national_id' => $request->national_id,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'relationship_to_patient' => $request->relationship_to_patient,
                'medical_record_number' => $medical_record_number,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('patients')->with('success', 'Patient registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('patients')->with('error', 'Failed to register patient: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('backend.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        // Fetch the patient
        $patient = Patient::findOrFail($id);

        // Validate incoming data
        $validated = $request->validate([
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'email' => 'nullable|email|max:150|unique:patients,email,' . $patient->id,
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before_or_equal:today',
            'national_id' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:150',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'relationship_to_patient' => 'nullable|string|max:100',
        ]);

        // Update the patient record
        $patient->fill($validated);

        $patient->save();

        return redirect()
            ->route('patients')
            ->with('success', 'Patient details updated successfully.');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        return view('backend.patients.show', compact('patient'));
    }

    public function destroy($id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients')->with('success', 'Patient deleted successfully.');
    }

    public function report()
    {
        $query = Patient::query();

        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $patients = $query->latest()->paginate(10);

        return view('backend.patients.reports', [
            'patients' => $patients,
            'canExport' => true,
        ]);
    }
}
