<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\Department;
use App\Models\Blog;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\Faq;

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
        $faq = Faq::all();
        return view('frontend.home.faqs', compact('faq'));
    }

    public function gallery()
    {
        $gallery = Gallery::all();
        return view('frontend.home.gallery', compact('gallery'));
    }

    public function services()
    {
        $services = Service::all();
        return view('frontend.services.index', compact('services'));
    }

    public function serviceDetails($id)
    {
        $service = Service::firstOrFail($id);
        return view('frontend.services.serviceDetails', compact('service'));
    }

    public function department()
    {
        $departments = Department::all();
        $blogs = Db::table('blogs')->orderBy('id', 'desc')->limit(3)->get();
        return view('frontend.departments.index', compact('departments', 'blogs'));
    }

    public function departmentDetails($id)
    {
        $department = Department::firstOrFail($id);
        return view('frontend.departments.departmentDetails', compact('department'));
    }

    public function doctors()
    {
        $doctors = Doctor::all();
        return view('frontend.doctors.index', compact('doctors'));
    }

    public function doctorsDetails($id)
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

       DB::beginTransaction();

        try {
            $subscriber = new Subscriber();
            $subscriber->name = $request->name;
            $subscriber->email = $request->email;
            $subscriber->save();

            DB::commit();
            return redirect()->route('home')->with('success', 'Subscribed successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}
