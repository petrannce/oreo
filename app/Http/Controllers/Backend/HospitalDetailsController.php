<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HospitalDetail;
use Illuminate\Http\Request;
use DB;

class HospitalDetailsController extends Controller
{
    public function index()
    {
        $hospital_details = HospitalDetail::all();
        return view('backend.hospital_details.index', compact('hospital_details'));
    }

    public function create()
    {
        return view('backend.hospital_details.create');
    }

    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::beginTransaction();

        try {

            $hospital_detail = new HospitalDetail();

            
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('uploads/hospitals/logos', 'public');
                $hospital_detail->logo = $logoPath;
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/hospitals/images', 'public');
                $hospital_detail->image = $imagePath;
            }
            
            $hospital_detail->name = $request->name;
            $hospital_detail->address = $request->address;
            $hospital_detail->phone_number = $request->phone_number;
            $hospital_detail->email = $request->email;
            $hospital_detail->website = $request->website;

            $hospital_detail->save();

            DB::commit();

            return redirect()
                ->route('hospital_details')
                ->with('success', 'Hospital details created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $hospital_detail = HospitalDetail::findOrFail($id);
        return view('backend.hospital_details.edit', compact('hospital_detail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        DB::beginTransaction();

        try {
            $hospital_detail = HospitalDetail::findOrFail($id);

            $hospital_detail->name = $request->name;
            $hospital_detail->address = $request->address;
            $hospital_detail->phone_number = $request->phone_number;
            $hospital_detail->email = $request->email;
            $hospital_detail->website = $request->website;

            // ✅ Handle Logo Upload
            if ($request->hasFile('logo')) {
                if ($hospital_detail->logo && file_exists(public_path('storage/' . $hospital_detail->logo))) {
                    unlink(public_path('storage/' . $hospital_detail->logo)); // delete old file
                }
                $path = $request->file('logo')->store('hospitals/logos', 'public');
                $hospital_detail->logo = $path;
            }

            // ✅ Handle Main Image Upload
            if ($request->hasFile('image')) {
                if ($hospital_detail->image && file_exists(public_path('storage/' . $hospital_detail->image))) {
                    unlink(public_path('storage/' . $hospital_detail->image)); // delete old file
                }
                $path = $request->file('image')->store('hospitals/images', 'public');
                $hospital_detail->image = $path;
            }

            $hospital_detail->save();

            DB::commit();
            return redirect()->route('hospital_details')
                ->with('success', 'Hospital details updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update hospital details. ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        DB::table('hospital_details')->where('id', $id)->delete();
        return redirect()->route('hospital_details.index')->with('success', 'Hospital details deleted successfully');
    }
}
