<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Doctor;
use DB;
use Log;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();

        return view('backend.doctors.index', [
            'doctors' => $doctors,
        ]);
    }

    public function create()
    {
        $users = User::where('role', 'doctor')
        ->whereDoesntHave('doctor')
        ->get();
        $departments = DB::table('departments')->get();
        return view('backend.doctors.create', compact('users', 'departments'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'department' => 'required',
            'speciality' => 'required',
            'employment_type' => 'required',
            'license_number' => 'required',
            'bio' => 'required',
        ]);

        DB::beginTransaction();

        try {

            // Create the doctor
            Doctor::create([
                'user_id' => $request->user_id,
                'department' => $request->department,
                'speciality' => $request->speciality,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'bio' => $request->bio,
            ]);
            
            DB::commit();
            return redirect()->route('doctors.index')->with('success', 'Doctor and profile created successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
            Log::error('Failed to create doctor and profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create doctor and profile');
        }
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $departments = DB::table('departments')->get();
        return view('backend.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'required',
            'department' => 'required',
            'speciality' => 'required',
            'employment_type' => 'required',
            'license_number' => 'required',
            'bio' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $doctor = Doctor::findOrFail($id);

            // Update doctor
            $doctor->update([
                'user_id' => $request->user_id,
                'department' => $request->department,
                'speciality' => $request->speciality,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'bio' => $request->bio,
            ]);
            
            DB::commit();
            return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('doctors.index')->with('error', 'Doctor update failed');
        }
    }

    public function show($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('backend.doctors.show', compact('doctor'));
    }

    public function destroy($id)
    {
        DB::table('doctors')->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }

    public function report()
    {
        // Start query — don't call get() yet
        $query = Doctor::with(['user']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $doctors = $query->latest()->paginate(10);

        return view('backend.doctors.reports', [
            'doctors' => $doctors,
            'canExport' => true
        ]);
    }

}
