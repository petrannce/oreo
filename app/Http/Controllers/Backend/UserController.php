<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // Get the results and return them as a collection
        $users = User::with('profile')->latest()->get();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

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
        return view('backend.users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::with('profile')->findOrFail($id);
        $tab = $request->input('tab');

        /* ---------------------------------------------------------------------
         * 🧩 PROFILE DETAILS UPDATE
         * ------------------------------------------------------------------- */
        if ($tab === 'profile') {

            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone_number' => 'nullable|string|max:50',
                'gender' => 'nullable|string|max:10',
                'city' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:500',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Update basic user info
            $user->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $request->username,
                'email' => $request->email,
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('profile_images', 'public');

                if ($user->profile && $user->profile->image) {
                    Storage::disk('public')->delete($user->profile->image);
                }

                $user->profile()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['image' => $path]
                );
            }

            // Update or create profile record
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
                    'city' => $request->city,
                    'country' => $request->country,
                    'address' => $request->address,
                ]
            );

            return back()->with('success', 'Profile updated successfully!');
        }

        /* ---------------------------------------------------------------------
         * 🔒 PASSWORD CHANGE
         * ------------------------------------------------------------------- */
        if ($tab === 'password') {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect.');
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return back()->with('success', 'Password updated successfully!');
        }

        /* ---------------------------------------------------------------------
         * 🖼️ IMAGE-ONLY UPDATE (sidebar quick upload)
         * ------------------------------------------------------------------- */
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');

            if ($user->profile && $user->profile->image) {
                Storage::disk('public')->delete($user->profile->image);
            }

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['image' => $path]
            );

            return back()->with('success', 'Profile image updated!');
        }

        return back()->with('error', 'No update action detected.');
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
        $validRoles = ['admin', 'patient', 'receptionist', 'doctor', 'nurse', 'lab_technician', 'pharmacist', 'accountant'];

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

    public function updateStatus($id, $status)
    {
        $user = User::findOrFail($id);

        if (!$user->profile) {
            return redirect()->back()->with('error', 'User profile not found.');
        }

        $allowedStatuses = ['active', 'inactive'];
        if (!in_array($status, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        $user->profile->status = $status;
        $user->profile->save();

        return redirect()->back()->with('success', "User status updated to {$status}.");
    }


    public function checkUsername(Request $request)
    {
        $exists = User::where('username', $request->username)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function report()
    {
        // Start query — don't call get() yet
        $users = User::query();

        // Add filters
        if (request('search')) {
            $users->where(function ($query) {
                $query->where('fname', 'like', '%' . request('search') . '%')
                    ->orWhere('lname', 'like', '%' . request('search') . '%')
                    ->orWhere('email', 'like', '%' . request('search') . '%')
                    ->orWhere('username', 'like', '%' . request('search') . '%');
            });
        }

        // Get the results and return them as a collection
        $users = $users->latest()->get();

        return view('backend.users.reports', compact('users'));
    }



}
