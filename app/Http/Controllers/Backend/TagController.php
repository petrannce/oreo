<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(){

        $tags = Tag::all();
        return view('backend.tags.index', compact('tags'));
    }

    public function create(){
        return view('backend.tags.create');
    }

    public function store(Request $request){

       $request->validate([
           'name' => 'required'
       ]);

       DB::beginTransaction();
       try {
           $tag = new Tag();
           $tag->name = $request->name;
           $tag->save();
           DB::commit();
           return redirect()->route('tags')->with('success', 'Tag created successfully');
       } catch (\Exception $e) {
           DB::rollBack();
           return redirect()->route('tags')->with('error', 'Tag creation failed');
       }
    }

    public function edit($id){

        $tag = Tag::findOrFail($id);
        return view('backend.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $tag = Tag::find($id);
            $tag->name = $request->name;
            $tag->save();
            DB::commit();
            
            return redirect()->route('tags')->with('success', 'Tag updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tags')->with('error', 'Tag update failed');
        }
    }

    public function destroy($id){

        DB::table('tags')->where('id', $id)->delete();
        return redirect()->route('tags')->with('success', 'Tag deleted successfully');
    }

}
