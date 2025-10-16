<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use DB;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->get();
        return view('backend.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('backend.medicines.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'form' => 'required',
            'stock_quantity' => 'required',
            'unit_price' => 'required',
            'manufacturer' => 'required',
            'expiry_date' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $medicine = new Medicine();
            $medicine->name = $request->name;
            $medicine->category = $request->category;
            $medicine->form = $request->form;
            $medicine->stock_quantity = $request->stock_quantity;
            $medicine->unit_price = $request->unit_price;
            $medicine->manufacturer = $request->manufacturer;
            $medicine->expiry_date = $request->expiry_date;

            $medicine->save();

            DB::commit();
            return redirect()->route('medicines')->with('success', 'Medicine created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('backend.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'form' => 'required',
            'stock_quantity' => 'required',
            'unit_price' => 'required',
            'manufacturer' => 'required',
            'expiry_date' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->name = $request->name;
            $medicine->category = $request->category;
            $medicine->form = $request->form;
            $medicine->stock_quantity = $request->stock_quantity;
            $medicine->unit_price = $request->unit_price;
            $medicine->manufacturer = $request->manufacturer;
            $medicine->expiry_date = $request->expiry_date;
            $medicine->save();

            DB::commit();
            return redirect()->route('medicines')->with('success', 'Medicine updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function destroy($id)
    {
        DB::table('medicines')->where('id', $id)->delete();
        return redirect()->route('medicines')->with('success', 'Medicine deleted successfully');
    }

    public function report(Request $request)
    {
        // Start query — don't call get() yet
        $query = Medicine::query();

        // Apply filters
        if ($request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $medicines = $query->latest()->paginate(10);

        return view('backend.departments.reports', [
            'medicines' => $medicines,
            'canExport' => true
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $medicines = Medicine::where('name', 'like', "%{$q}%")
            ->limit(10)
            ->get(['id', 'name', 'form', 'stock_quantity', 'unit_price']);
        return response()->json($medicines);
    }

}
