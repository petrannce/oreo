<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('backend.appointments.index');
    }

    public function create()
    {
        return view('backend.appointments.create');
    }
}
