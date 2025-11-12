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
                $logo = $request->file('logo');

                $logoPath = public_path('hospitals/logos');
                if (!file_exists($logoPath)) {
                    mkdir($logoPath, 0777, true);
                }

                $logo_name = time() . '_' . preg_replace('/\s+/', '_', $logo->getClientOriginalName());
                $logo->move($logoPath, $logo_name);
                $hospital_detail->logo = 'hospitals/logos/' . $logo_name;
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                $imagePath = public_path('hospitals/images');
                if (!file_exists($imagePath)) {
                    mkdir($imagePath, 0777, true);
                }

                $image_name = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move($imagePath, $image_name);
                $hospital_detail->image = 'hospitals/images/' . $image_name;
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

    public function edit($id = null)
    {
        $hospital_detail = $id ? HospitalDetail::find($id) : new HospitalDetail;
        return view('backend.hospital_details.edit', compact('hospital_detail'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $hospital_detail = HospitalDetail::findOrFail($id);
            $inline = $request->input('inline'); // check which part is being updated

            // ✅ Handle Logo only
            if ($inline === 'logo' && $request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logo_name = time() . '_' . preg_replace('/\s+/', '_', $logo->getClientOriginalName());
                $logo->move(public_path('hospitals/logos'), $logo_name);
                $hospital_detail->logo = 'hospitals/logos/' . $logo_name;
                $hospital_detail->save();

                DB::commit();
                return redirect()->route('hospital_details')
                    ->with('success', 'Hospital logo updated successfully.');
            }

            // ✅ Handle Banner/Image only
            if ($inline === 'image' && $request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('hospitals/images'), $image_name);
                $hospital_detail->image = 'hospitals/images/' . $image_name;
                $hospital_detail->save();

                DB::commit();
                return redirect()->route('hospital_details')
                    ->with('success', 'Hospital banner updated successfully.');
            }

            // ✅ Handle full hospital details update
            if ($inline === null) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'address' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'email' => 'required|email|max:255',
                    'website' => 'nullable|url|max:255',
                ]);

                $hospital_detail->name = $request->name;
                $hospital_detail->address = $request->address;
                $hospital_detail->phone_number = $request->phone_number;
                $hospital_detail->email = $request->email;
                $hospital_detail->website = $request->website;
                $hospital_detail->save();

                DB::commit();
                return redirect()->route('hospital_details')
                    ->with('success', 'Hospital details updated successfully.');
            }

            DB::rollBack();
            return redirect()->back()->with('error', 'Nothing to update.');

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
        return redirect()->route('hospital_details')->with('success', 'Hospital details deleted successfully');
    }
}
