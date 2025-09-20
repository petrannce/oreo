<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Receptionist;
use App\Models\User;
use illuminate\Support\Facades\Hash;
class ReceptionistController extends Controller
{
    public function index()
    {
        $receptionists = Receptionist::with('user')->get();
        return view('backend.receptionists.index', compact('receptionists'));
    }

    public function create()
    {
        return view('backend.receptionists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'employee_code' => 'required|unique:receptionists,employee_code',
            'department' => 'nullable|string',
            'hire_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Create user
            $user = User::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => strtolower($request->fname . '.' . $request->lname),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'receptionist',
            ]);

            // Create receptionist
            Receptionist::create([
                'user_id' => $user->id,
                'employee_code' => $request->employee_code,
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
        return view('backend.receptionists.edit', compact('receptionist'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'nullable',
            'employee_code' => 'required|unique:receptionists,employee_code,' . $id,
            'department' => 'nullable|string',
            'hire_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            $receptionist = Receptionist::findOrFail($id);

            // Update user
            $receptionist->user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password ? Hash::make($request->password) : $receptionist->user->password,
            ]);

            // Update receptionist
            $receptionist->update([
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
