<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('backend.doctors.index');
    }

    public function create()
    {
        return view('backend.doctors.create');
    }
}
