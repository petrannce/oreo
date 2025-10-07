<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\PharmacyOrderItem;
use DB;
use Illuminate\Http\Request;

class PharmacyOrderItemController extends Controller
{
    public function index()
    {
        // Start query — don't call get() yet
        $query = PharmacyOrderItem::with(['pharmacy_order']);

        // Apply filters
        if (request()->from_date) {
            $query->whereDate('created_at', '>=', request()->from_date);
        }

        if (request()->to_date) {
            $query->whereDate('created_at', '<=', request()->to_date);
        }

        $pharmacy_order_items = $query->latest()->paginate(10);

        return view('backend.pharmacy_orders_items.index', [
            'pharmacy_order_items' => $pharmacy_order_items,
            'canExport' => true
        ]);
    }

    public function create()
    {
        $pharmacy_orders = PharmacyOrderItem::all();
        return view('backend.pharmacy_orders_items.create', compact('pharmacy_orders'));
    }

    public function store(Request $request)
    {
       $request->validate([
        'pharmacy_order_id' => 'required|exists:pharmacy_orders,id',
        'drug_name' => 'required|string|max:255',    
        'quantity' => 'required|numeric',
        'dosage' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $pharmacy_order_item = new PharmacyOrderItem();
            $pharmacy_order_item->pharmacy_order_id = $request->pharmacy_order_id;
            $pharmacy_order_item->drug_name = $request->drug_name;
            $pharmacy_order_item->quantity = $request->quantity;
            $pharmacy_order_item->dosage = $request->dosage;
            $pharmacy_order_item->save();

            DB::commit();
            return redirect()->route('pharmacy_orders_items')->with('success', 'Pharmacy order item added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add pharmacy order item. Please try again.');
        }

    }
}
