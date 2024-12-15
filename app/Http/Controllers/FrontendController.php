<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('frontend.department.index');
    }

    public function departmentDetails()
    {
        return view('frontend.department.departmentDetails');
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
}
