<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Medical;
use Illuminate\Http\Request;

class MedicalController extends Controller
{
    public function index()
    {
        $medical_records = Medical::all();
        return view('backend.medicals.index', compact('medical_records'));
    }
}
