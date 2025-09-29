<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->profile()->create([
            'user_id' => $user->id,
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'status' => 'active',
            'image' => $request->image,
        ]);
        return redirect()->route('users')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id, // Ensure unique email for users
            'password' => 'nullable',
        ]);

        $user->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users')->with('success', 'User updated successfully');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.users.show', compact('user'));
    }

    public function destroy($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('users')->with('success', 'User deleted successfully');
    }

    public function updateRole($id, $role)
    {
        $user = User::findOrFail($id);
        $validRoles = ['admin', 'patient', 'receptionist', 'doctor'];

        if (!in_array($role, $validRoles)) {
            return redirect()->back()->with('error', 'Invalid role selected');
        }

        //sync Spatie role
        $user->syncRoles([$role]);

        //Update the role column in users table
        $user->update(['role' => $role]);

        // Clear Spatie cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions(); // Clear Spatie cache

        // If the authenticated user is changing their own role, update their session
        if (Auth::id() == $user->id) {
            Auth::logout();
            Session::flush(); // Clear the session
            return redirect('/')->with('success', 'Role updated successfully! Please login again');
        }

        return redirect()->back()->with('success', 'Role updated successfully!');
    }


}
