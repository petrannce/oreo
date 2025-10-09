<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NurseController extends Controller
{
    public function index()
    {
        $nurses = Nurse::all();

        return view('backend.nurses.index', [
            'nurses' => $nurses,
        ]);
    }
 
    public function create()
    {
        $users = User::where('role', 'nurse')
        ->whereDoesntHave('nurse')
        ->get();
        $departments = Department::all();
        return view('backend.nurses.create',compact('users','departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'license_number' => 'nullable|string',
            'employee_code' => 'nullable|string|unique:nurses,employee_code',
            'hire_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // Get last receptionist entry
            $lastNurse = Nurse::whereNotNull('employee_code')
                ->orderBy('id', 'desc')
                ->select('employee_code')
                ->first();

            // Generate new employee code if not provided
            if($lastNurse && preg_match('/(\d+)$/', $lastNurse->employee_code, $m)) {
                $nextNumber = intval($m[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $employee_code = 'NRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            while(Nurse::where('employee_code', $employee_code)->exists()) {
                $nextNumber++;
                $employee_code = 'NRN' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $finalcode = $request->employee_code ?? $employee_code;

            Nurse::create([
                'user_id' => $request->user_id,
                'department' => $request->department,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'employee_code' => $finalcode,
                'hire_date' => $request->hire_date,
                'bio' => $request->bio,
            ]);
            
            DB::commit();
            return redirect()->route('nurses')->with('success', 'Nurse created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('nurses')->with('error', 'Nurse creation failed');
        }

    }

    public function edit($id)
    {
         $nurse = Nurse::findOrFail($id);
        return view('backend.nurses.edit', compact('nurse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'license_number' => 'nullable|string',
            'employee_code' => 'nullable|string|unique:nurses,employee_code,' . $id,
            'hire_date' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $nurse = Nurse::findOrFail($id);

            // Update receptionist
            $nurse->update([
                'department' => $request->department,
                'employment_type' => $request->employment_type,
                'license_number' => $request->license_number,
                'employee_code' => $request->employee_code,
                'hire_date' => $request->hire_date,
                'bio' => $request->bio,
            ]);
            
            DB::commit();
            return redirect()->route('nurses')->with('success', 'Nurse updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('nurses')->with('error', 'Nurse update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('nurses')->where('id', $id)->delete();
        return redirect()->route('nurses')->with('success', 'Nurse deleted successfully');
    }

    public function report()
    {
        // Start query — don't call get() yet
        $query = Nurse::with(['user']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $nurses = $query->latest()->get();

        return view('backend.nurses.reports', [
            'nurses' => $nurses,
            'canExport' => true
        ]);
    }
}
