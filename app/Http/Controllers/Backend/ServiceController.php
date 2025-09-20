<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use DB;

class ServiceController extends Controller
{
    public function index(){

        $services = Service::all();
        return view('backend.services.index', compact('services'));
    }

    public function create(){
        return view('backend.services.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try{ 
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move('public/services', $image_name);
            } else {
                $image_name = null;
            }
    
            $service = new Service();
            $service->name = $request->name;
            $service->description = $request->description;
            $service->image = $image_name;
            $service->save();
    
            DB::commit();
            return redirect()->route('services.index');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('services.index');
        }
    }

    public function edit($id){
        $service = Service::find($id);
        return view('backend.services.edit', compact('service'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        //dd($request->all());

        DB::beginTransaction();

        try{

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move('public/services', $image_name);
            } else {
                $image_name = null;
            }
    
            $service = Service::find($id);
            $service->name = $request->name;
            $service->description = $request->description;
            $service->image = $image_name;
            $service->save();
    
            DB::commit();
            return redirect()->route('services.index');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('services.index');
        }
    }

    public function destroy($id){
        
        DB::table('services')->where('id', $id)->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully');
    }
}
