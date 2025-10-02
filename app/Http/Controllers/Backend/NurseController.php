<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function index()
    {
        return view('backend.nurses.index');
    }
 
    public function create()
    {
        $users = User::where('role', 'nurse')
        ->whereDoesntHave('nurse')
        ->get();
        return view('backend.nurses.create',compact('users'));
    }

    public function store(Request $request)
    {
        

        return redirect()->route('nurses')->with('success', 'Nurse created successfully');
    }

    public function edit($id)
    {
         $nurse = Nurse::findOrFail($id);
        return view('backend.nurses.edit'); //, compact('nurse'));
    }

    public function update(Request $request, $id)
    {
        // Validate and update the nurse data
        // Example:
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:nurses,email,' . $id,
        //     // Add other fields as necessary
        // ]);

        // $nurse = Nurse::findOrFail($id);
        // $nurse->update($request->all());

        return redirect()->route('nurses')->with('success', 'Nurse updated successfully');
    }

    public function destroy($id)
    {
         $nurse = Nurse::findOrFail($id);
         $nurse->delete();

        return redirect()->route('nurses')->with('success', 'Nurse deleted successfully');
    }
}
