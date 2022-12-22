<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function post_landing(){
        return view('apps.landing.post');
    }
    public function course_landing(){
        return view('apps.landing.course');
    }

}
