<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tag;
use DB;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return view('backend.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('backend.blogs.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'tag' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $image_name);
            }
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->tag = $request->tag;
            $blog->description = $request->description;
            $blog->image = $image_name;
            $blog->save();
            DB::commit();
            return redirect()->route('blogs')->with('success', 'Blog created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('blogs.create')->with('error', 'Blog creation failed');
        }
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('backend.blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'tag' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $image_name);
            }
            $blog = Blog::find($id);
            $blog->title = $request->title;
            $blog->tag = $request->tag;
            $blog->description = $request->description;
            $blog->image = $image_name;
            $blog->save();
            DB::commit();
            return redirect()->back()->with('success', 'Blog updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Blog update failed');
        }
    }

    public function destroy($id)
    {
        DB::table('blogs')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Blog deleted successfully');
    }
}
