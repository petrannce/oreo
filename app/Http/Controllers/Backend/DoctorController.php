<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use DB;

class DoctorController extends Controller
{
    public function index()
    {
        return view('backend.doctors.index');
    }

    public function create()
    {
        return view('backend.doctors.create');
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:doctors,email', // Ensure unique email for doctors
            'speciality' => 'required',
            'department' => 'required',
            'employment_type' => 'required',
            'description' => 'required',
            'profile_type' => 'nullable|in:doctor',
            'country' => 'nullable',
            'city' => 'nullable',
            'address' => 'required',
            'phone_number' => 'nullable',
            'gender' => 'nullable',
            'status' => 'nullable|in:active,inactive', // Ensure only 'active' or 'inactive'
            'image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/doctors'), $imageName);
            }

            // Create the doctor
            $doctor = new Doctor();
            $doctor->fname = $request->fname;
            $doctor->lname = $request->lname;
            $doctor->email = $request->email;
            $doctor->speciality = $request->speciality;
            $doctor->department = $request->department;
            $doctor->employment_type = $request->employment_type;
            $doctor->description = $request->description;
            $doctor->save();

            $doctor->profile()->create([ // Using the relationship to create the profile
                'profile_type' => 'doctor',
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'status' => $request->status,
                'image' => $imageName,
            ]);

            // Commit the transaction
            DB::commit();
            return redirect()->route('doctors')->with('success', 'Doctor and profile created successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create doctor and profile');
        }
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('backend.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:doctors,email,' . $id, // Ensure unique email for doctors
            'speciality' => 'required',
            'department' => 'required',
            'employment_type' => 'required',
            'description' => 'required',
            'profile_type' => 'required|in:doctor',
            'country' => 'nullable',
            'city' => 'nullable',
            'address' => 'required',
            'phone_number' => 'nullable',
            'gender' => 'nullable',
            'status' => 'required|in:active,inactive', // Ensure only 'active' or 'inactive'
            'image' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Find the doctor by ID
            $doctor = Doctor::findOrFail($id);

            // Handle the image upload if a new one is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($doctor->profile && $doctor->profile->image) {
                    $oldImagePath = public_path('images/doctors/' . $doctor->profile->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete the old image
                    }
                }

                // Store the new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/doctors'), $imageName);

                // Update the doctor's profile image
                $doctor->profile->image = $imageName;
            }

            // Update the doctor’s details
            $doctor->fname = $request->fname;
            $doctor->lname = $request->lname;
            $doctor->email = $request->email;
            $doctor->speciality = $request->speciality;
            $doctor->department = $request->department;
            $doctor->employment_type = $request->employment_type;
            $doctor->description = $request->description;
            $doctor->save();

            // Update the profile details using the relationship
            $doctor->profile()->update([
                'profile_type' => 'doctor', // Set profile type to 'doctor' (fixed value)
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'gender' => $request->gender,
                'status' => $request->status ?? 'active', // Default to 'active' if no status is provided
            ]);

            // Commit the transaction
            DB::commit();

            return redirect()->route('doctors.index')->with('success', 'Doctor and profile updated successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if anything fails
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update doctor and profile');
        }
    }

    public function destroy($id)
    {
        DB::table('doctors')->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }

}
