<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.home.index');
    }

    public function about()
    {
        return view('frontend.home.about');
    }

    public function contact()
    {
        return view('frontend.home.contact');
    }

    public function faqs()
    {
        return view('frontend.home.faqs');
    }

    public function gallery()
    {
        return view('frontend.home.gallery');
    }

    public function services()
    {
        return view('frontend.services.index');
    }

    public function serviceDetails()
    {
        return view('frontend.services.serviceDetails');
    }

    public function department()
    {
        return view('frontend.departments.index');
    }

    public function departmentDetails()
    {
        return view('frontend.departments.departmentDetails');
    }

    public function doctors()
    {
        return view('frontend.doctors.index');
    }

    public function doctorsDetails()
    {
        return view('frontend.doctors.doctorsDetails');
    }

    public function blog()
    {
        return view('frontend.blogs.index');
    }

    public function blogDetails()
    {
        return view('frontend.blogs.blogDetails');
    }

    public function subscriber()
    {
        return view('frontend.subscribers.index');
    }

    public function subscriberStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:subscribers',
        ]);

        $subscriber = new Subscriber();
        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->save();

        return redirect()->route('home')->with('success', 'Subscribed successfully');
    }
}
