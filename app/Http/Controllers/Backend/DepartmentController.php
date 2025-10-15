<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use DB;

class DepartmentController extends Controller
{
    public function index()
    {
         $departments = Department::latest()->get();

        return view('backend.departments.index', [
            'departments' => $departments,
        ]);
    }

    public function create()
    {
        return view('backend.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction(); // Transaction starts
        try {

            $department = new Department();
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();

            DB::commit(); 
            return redirect()->route('departments')->with('success', 'Department created successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Transaction rollback
            return redirect()->route('departments')->with('error', 'Department creation failed');
        }
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('backend.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction(); // Transaction starts
        try {
            $department = Department::findOrFail($id);

            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();

            DB::commit(); 
            return redirect()->route('departments')->with('success', 'Department updated successfully');
        } catch (\Exception $e) {
            DB::rollBack(); // Transaction rollback
            return redirect()->route('departments')->with('error', 'Department update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('departments')->where('id', $id)->delete();
        return redirect()->route('departments')->with('success', 'Department deleted successfully');
    }

    public function report(Request $request)
    {
         // Start query — don't call get() yet
        $query = Department::query();

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $departments = $query->latest()->paginate(10);

        return view('backend.departments.reports', [
            'departments' => $departments,
            'canExport' => true
        ]);
    }
}
