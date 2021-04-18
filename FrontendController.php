<?php

namespace App\Http\Controllers;


use App\Models\Notice;
use App\Models\Books;
use App\Models\News;
use App\Models\Notice as ModelsNotice;
use App\Models\staff;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error\Notice as ErrorNotice;

class FrontendController extends Controller
{
    public function homepage(){

        // $notice = Notice::all();
        return view('frontend.pages.index');
    }
    public function notice(){

        $notice = Notice::paginate(8);
        return view('frontend.pages.notice')->with('notice',$notice);

    }


    public function admission(){
        return view('frontend.pages.admission');
    }

    public function admissionapply(){
        return view('frontend.pages.apply');
    }


    public function events(){
        $event = News::where('status', 'active')->paginate(9);
        return view('frontend.pages.events')->with('event', $event);
    }

    public function eventdetail($slug){
        $event = News::where('slug', $slug)->first();
        $events = News::where('status', 'active')->latest()->take(5)->get();
        return view('frontend.pages.eventdetail',compact('event', 'events'));
    }


    public function program(){
        return view('frontend.pages.program');
    }


    public function staff(){
        $stff = Teacher::all();
        $stfff = staff::all();
        return view('frontend.pages.staff')->with('stff', $stff)->with('stfff', $stfff);
    }


    public function aboutus(){
        return view('frontend.pages.aboutus');
    }

    public function studentregitration(){
        return view('frontend.pages.studentregister');
    }
    public function teacherregistration(){
        return view('frontend.pages.teacherregistration');
    }
    public function hf(){

        $hf = Notice::all();
        return view('frontend.layout.hf')->with('hf', $hf);
    }

}
