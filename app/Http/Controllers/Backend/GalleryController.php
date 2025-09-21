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
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '_' . $image->getClientOriginalName();
                $image->move('public/galleries', $image_name);
            } else {
                $image_name = null;
            }

            $gallery = new Gallery();
            $gallery->title = $request->title;
            $gallery->image = $image_name;
            $gallery->save();

            DB::commit();
            return redirect()->route('galleries.index')->with('success', 'Gallery created successfully');
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
            'image' => 'required|image',
        ]);

        DB::beginTransaction();

        try {
            $gallery = Gallery::findOrFail($id);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('public/galleries'), $image_name);
                $request->image = $image_name;
            }

            $gallery->title = $request->title;
            $gallery->image = $request->image;
            $gallery->save();

            DB::commit();
            return redirect()->route('galleries.index')->with('success', 'Gallery updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        DB::table('galleries')->where('id', $id)->delete();
        return redirect()->route('galleries.index')->with('success', 'Gallery deleted successfully');
    }
}
