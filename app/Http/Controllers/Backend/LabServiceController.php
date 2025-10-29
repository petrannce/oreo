<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LabService;
use Illuminate\Http\Request;
use DB;

class LabServiceController extends Controller
{
    public function index()
    {
        $lab_services = LabService::latest()->get();
        return view('backend.lab_services.index', compact('lab_services'));
    }

    public function create()
    {
        return view('backend.lab_services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $lab_service = new LabService();
            $lab_service->test_name = $request->test_name;
            $lab_service->price = $request->price;
            $lab_service->save();

            DB::commit();
            return redirect()->route('lab_services')->with('success', 'Lab service created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create lab service. Please try again.');
        }
    }

    public function edit($id)
    {
        $lab_service = LabService::findOrFail($id);
        return view('backend.lab_services.edit', compact('lab_service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $lab_service = LabService::findOrFail($id);
            $lab_service->test_name = $request->test_name;
            $lab_service->price = $request->price;
            $lab_service->save();

            DB::commit();
            return redirect()->route('lab_services')->with('success', 'Lab service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update lab service. Please try again.');
        }
    }

    public function destroy($id)
    {
        DB::table('lab_services')->where('id', $id)->delete();
        return redirect()->back()->with('error', 'Failed to delete lab service. Please try again.');
    }

    public function report(Request $request)
    {
         // Start query — don't call get() yet
        $query = LabService::query();

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $lab_services = $query->latest()->paginate(10);

        return view('backend.lab_services.reports', [
            'lab_services' => $lab_services,
            'canExport' => true
        ]);
    }

}
