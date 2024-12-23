<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admin()
    {
        return view('backend.dashboard.admin');
    }

    public function subscribers()
    {
        return view('backend.subscribers.index');
    }

    public function subscribersDestroy($id)
    {
        DB::table('subscribers')->where('id', $id)->delete();
        return redirect()->route('subscribers')->with('success', 'Subscriber deleted successfully');
    }
}
