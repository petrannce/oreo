<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\Department;
use App\Models\Blog;
use App\Models\Doctor;

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

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        return redirect()->route('contact')->with('success', 'Message sent successfully');
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
        $departments = Department::all();
        return view('frontend.departments.index', compact('departments'));
    }

    public function departmentDetails()
    {
        return view('frontend.departments.departmentDetails');
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        return view('frontend.doctors.index', compact('doctors'));
    }

    public function doctorsDetails()
    {
        $doctor = Doctor::firstOrFail($id);
        return view('frontend.doctors.doctorsDetails', compact('doctor'));
    }

    public function blog()
    {
        $blogs = Blog::all();
        return view('frontend.blogs.index', compact('blogs'));
    }

    public function blogDetails($id)
    {
        $blog = Blog::firstOrFail($id);
        return view('frontend.blogs.blogDetails', compact('blog'));
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
