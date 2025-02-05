<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use App\Models\Receptionist;
class ReceptionistController extends Controller
{
    public function index()
    {
        $receptionists = Receptionist::all();
        return view('backend.receptionists.index', compact('receptionists'));
    }

    public function create()
    {
        return view('backend.receptionists.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $receptionist = new Receptionist();
            $receptionist->fname = $request->fname;
            $receptionist->lname = $request->lname;
            $receptionist->email = $request->email;
            $receptionist->phone = $request->phone;
            $receptionist->save();
            
            DB::commit();
            return redirect()->route('receptionists')->with('success', 'Receptionist created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('receptionists')->with('error', 'Receptionist creation failed');
        }
    }

    public function edit($id)
    {
        $receptionist = Receptionist::findOrFail($id);
        return view('backend.receptionists.edit', compact('receptionist'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $receptionist = Receptionist::findOrFail($id);
            $receptionist->fname = $request->fname;
            $receptionist->lname = $request->lname;
            $receptionist->email = $request->email;
            $receptionist->phone = $request->phone;
            $receptionist->save();
            
            DB::commit();
            return redirect()->route('receptionists')->with('success', 'Receptionist updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('receptionists')->with('error', 'Receptionist update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('receptionists')->where('id', $id)->delete();
        return redirect()->route('receptionists')->with('success', 'Receptionist deleted successfully');
    }
}
