<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return view('backend.patients.index');
    }

    public function create()
    {
        return view('backend.patients.create');
    }
}
