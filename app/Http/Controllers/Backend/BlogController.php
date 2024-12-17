<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('backend.blogs.index');
    }

    public function create()
    {
        return view('backend.blogs.create');
    }   
}
