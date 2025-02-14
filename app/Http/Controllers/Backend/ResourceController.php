<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use DB;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::all();
        return view('backend.resources.index', compact('resources'));
    }

    public function create()
    {
        return view('backend.resources.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $resource = new Resource();
            $resource->title = $request->title;
            $resource->type = $request->type;
            $resource->description = $request->description;
            $resource->save();

            DB::commit();
            return redirect()->route('resources')->with('success', 'Resource created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('resources')->with('error', 'Resource creation failed.');
        }

    }

    public function edit($id)
    {
        $resource = Resource::find($id);
        return view('backend.resources.edit', compact('resource'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $resource = Resource::find($id);
            $resource->title = $request->title;
            $resource->type = $request->type;
            $resource->description = $request->description;
            $resource->save();

            DB::commit();
            return redirect()->route('resources')->with('success', 'Resource updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('resources')->with('error', 'Resource update failed.');
        }
    }

    public function destroy($id)
    {
        DB::table('resources')->where('id', $id)->delete();
        return redirect()->route('resources')->with('success', 'Resource deleted successfully');
    }
}
