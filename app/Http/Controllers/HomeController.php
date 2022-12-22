<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function display(){
        return view('apps.web.display');
    }

    public function web(){
        return view('apps.web.home');
    }
    
    public function contact(){
        return view('apps.web.contact');
    }

    public function about(){
        return view('apps.web.about');
    }

    public function terms(){
        return view('apps.web.terms');
    }

    public function courses(){
        return view('apps.web.courses');
    }

    public function course_view(){
        return view('apps.web.course');
    }

    public function post_view(){
        return view('apps.web.post');
    }

}
