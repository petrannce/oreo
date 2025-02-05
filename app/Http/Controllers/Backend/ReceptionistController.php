<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Receptionist;
class ReceptionistController extends Controller
{
    public function index()
    {
        $receptionists = Receptionist::all();
        return view('backend.receptionists.index', compact('receptionists'));
    }

    public function create()
    {
        return view('backend.receptionist.create');
    }
}
