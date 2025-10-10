<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HospitalService;
use Illuminate\Http\Request;
use DB;

class HospitalServiceController extends Controller
{
    public function index()
    {
        $hospital_services = HospitalService::latest()->get();
        return view('backend.hospital_services.index', compact('hospital_services'));
    }

    public function create()
    {
        return view('backend.hospital_services.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $hospital_service = new HospitalService();
            $hospital_service->name = $request->name;
            $hospital_service->category = $request->category;
            $hospital_service->price = $request->price;
            $hospital_service->description = $request->description;

            $hospital_service->save();
            DB::commit();
            return redirect()->route('hospital_services')->with('success', 'Hospital service created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('hospital_services')->with('error', 'Hospital service creation failed');
        }

    }

    public function edit($id)
    {
        $hospital_service = HospitalService::findOrFail($id);
        return view('backend.hospital_services.edit', compact('hospital_service'));
    }

    public function update(Request $request, $id)
    {
        $request -> validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $hospital_service = HospitalService::findOrFail($id);
            $hospital_service->name = $request->name;
            $hospital_service->category = $request->category;
            $hospital_service->price = $request->price;
            $hospital_service->description = $request->description;

            $hospital_service->save();
            DB::commit();
            return redirect()->route('hospital_services')->with('success', 'Hospital service updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('hospital_services')->with('error', 'Hospital service update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('hospital_services')->where('id', $id)->delete();
        return redirect()->route('hospital_services')->with('success', 'Hospital service deleted successfully');
    }
}
