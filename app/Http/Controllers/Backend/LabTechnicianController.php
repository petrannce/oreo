<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\LabTechnician;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class LabTechnicianController extends Controller
{
    public function index()
    {
        $lab_technicians = LabTechnician::all();

        return view('backend.lab_technicians.index', [
            'lab_technicians' => $lab_technicians,
        ]);
    }

    public function create()
    {
        $users = User::where('role', 'lab_technician')
        ->whereDoesntHave('lab_technician')
        ->get();
        $departments = Department::all();
        return view('backend.lab_technicians.create', compact('users','departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'license_number' => 'nullable|string',
            'employee_code' => 'nullable|string|unique:lab_technicians,employee_code',
            'hire_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Get last receptionist entry
            $lastReceptionist = LabTechnician::whereNotNull('employee_code')
                ->orderBy('id', 'desc')
                ->select('employee_code')
                ->first();

            // Generate new employee code if not provided
            if($lastReceptionist && preg_match('/(\d+)$/', $lastReceptionist->employee_code, $m)) {
                $nextNumber = intval($m[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $employee_code = 'LT' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            while(LabTechnician::where('employee_code', $employee_code)->exists()) {
                $nextNumber++;
                $employee_code = 'LT' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            LabTechnician::create([
                'user_id' => $request->user_id,
                'department' => $request->department,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'employee_code' => $request->employee_code ?? $employee_code,
                'hire_date' => $request->hire_date,
                'bio' => $request->bio,
            ]);

            DB::commit();
            return redirect()->route('lab_technicians')->with('success', 'Lab Technician created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('lab_technicians')->with('error', 'Lab Technician creation failed');
        }
    }

    public function edit($id)
    {
        $lab_technician = LabTechnician::findOrFail($id);
        return view('backend.lab_technicians.edit', compact('lab_technician'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'license_number' => 'nullable|string',
            'employee_code' => 'nullable|string|unique:lab_technicians,employee_code,' . $id,
            'hire_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $lab_technician = LabTechnician::findOrFail($id);

            // Update receptionist
            $lab_technician->update([
                'department' => $request->department,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'employee_code' => $request->employee_code,
                'hire_date' => $request->hire_date,
                'bio' => $request->bio,
            ]);
            
            DB::commit();
            return redirect()->route('lab_technicians')->with('success', 'Lab Technician updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('lab_technicians')->with('error', 'Lab Technician update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('lab_technicians')->where('id', $id)->delete();
        return redirect()->route('lab_technicians')->with('success', 'Lab Technician deleted successfully');
    }

    public function report()
    {
        $query = LabTechnician::with('user');

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $lab_technicians = $query->latest()->get();

        return view('backend.lab_technicians.reports', [
            'lab_technicians' => $lab_technicians,
            'canExport' => true
        ]);
    }
}
