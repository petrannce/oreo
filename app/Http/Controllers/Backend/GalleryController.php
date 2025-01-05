<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('backend.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('backend.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $gallery = new Gallery();
            $gallery->title = $request->title;
            $gallery->image = $request->image;
            $gallery->save();

            DB::commit();
            return redirect()->route('galleries')->with('success', 'Gallery created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('backend.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $gallery = Gallery::findOrFail($id);
            $gallery->title = $request->title;
            $gallery->image = $request->image;
            $gallery->save();

            DB::commit();
            return redirect()->route('galleries')->with('success', 'Gallery updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        DB::table('galleries')->where('id', $id)->delete();
        return redirect()->route('galleries')->with('success', 'Gallery deleted successfully');
    }
}
