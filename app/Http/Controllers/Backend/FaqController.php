<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('backend.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('backend.faqs.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

       DB::beginTransaction();

        try {
            $faq = new Faq();
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            DB::commit();
            return redirect()->route('faqs')->with('success', 'Faq created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('backend.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $faq = Faq::find($id);
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            DB::commit();
            return redirect()->route('faqs')->with('success', 'Faq updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        DB::table('faqs')->where('id', $id)->delete();
        return redirect()->route('faqs')->with('success', 'Faq deleted successfully');
    }
}
