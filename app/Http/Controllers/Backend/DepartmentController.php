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
        $departments = Department::all();
        return view('backend.departments.index', compact('departments'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction(); // Transaction starts
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move('public/departments', $image_name);
            } else {
                $image_name = null;
            }

            $department = new Department();
            $department->name = $request->name;
            $department->description = $request->description;
            $department->image = $image_name;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction(); // Transaction starts
        try {
            $department = Department::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/departments'), $imageName);
                $department->image = $imageName;
            }

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
}
