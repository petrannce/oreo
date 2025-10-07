<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use DB;
use Illuminate\Http\Request;
use App\Models\Receptionist;
use App\Models\User;
use illuminate\Support\Facades\Hash;
class ReceptionistController extends Controller
{
    public function index()
    {
        // Start query — don't call get() yet
        $query = Receptionist::with(['user']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $receptionists = $query->latest()->paginate(10);

        return view('backend.receptionists.index', [
            'receptionists' => $receptionists,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $users = User::where('role', 'receptionist')
        ->whereDoesntHave('receptionist')
        ->get();
        $departments = Department::all();
        return view('backend.receptionists.create',compact('users','departments'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'department' => 'nullable|string',
            'hire_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {

            // Get last receptionist entry
            $lastReceptionist = Receptionist::whereNotNull('employee_code')
                ->orderBy('id', 'desc')
                ->select('employee_code')
                ->first();

            // Generate new employee code if not provided
            if($lastReceptionist && preg_match('/(\d+)$/', $lastReceptionist->employee_code, $m)) {
                $nextNumber = intval($m[1]) + 1;
            } else {
                $nextNumber = 1;
            }

            $employee_code = 'ER' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            while(Receptionist::where('employee_code', $employee_code)->exists()) {
                $nextNumber++;
                $employee_code = 'ER' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            $finalcode = $request->employee_code ?? $employee_code;

            Receptionist::create([
                'user_id' => $request->user_id,
                'employee_code' => $finalcode,
                'department' => $request->department,
                'hire_date' => $request->hire_date,
            ]);
            
            DB::commit();
            return redirect()->route('receptionists')->with('success', 'Receptionist created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('receptionists')->with('error', 'Receptionist creation failed');
        }
    }

    public function edit($id)
    {
        $receptionist = Receptionist::with('user')->findOrFail($id);
        $departments = Department::all();
        return view('backend.receptionists.edit', compact('receptionist', 'departments'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'user_id' => 'required',
            'employee_code' => 'required|unique:receptionists,employee_code,' . $id,
            'department' => 'required|string',
            'hire_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            $receptionist = Receptionist::findOrFail($id);

            // Update receptionist
            $receptionist->update([
                'user_id' => $request->user_id,
                'employee_code' => $request->employee_code,
                'department' => $request->department,
                'hire_date' => $request->hire_date,
            ]);
            
            DB::commit();
            return redirect()->route('receptionists')->with('success', 'Receptionist updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('receptionists')->with('error', 'Receptionist update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('receptionists')->where('id', $id)->delete();
        return redirect()->route('receptionists')->with('success', 'Receptionist deleted successfully');
    }
}
