<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{

   public function killSession(Request $request){
      if ($request->session()->has('userdata')) {
          setcookie("usercookie", "", time() - 3600, "/");
          $request->session()->flush('userdata');
          return true;
       }else{
          return true;
       }
  }

    public function logout(Request $request){
        if ($request->session()->has('userdata')) {
            setcookie("usercookie", "", time() - 3600, "/");
            $request->session()->flush('userdata');
            return view('apps.auths.logout');
         }else{
            return view('apps.auths.logout');

         }
    }

    public function confirmSession(Request $request){
        if ($request->session()->has('userdata')) {
           return true;
        }else{
           return false;
        }
        
    }

   //  Not in use yet
    public function setSession(Request $request){
        if ($request->session()->has('userdata')) {
            return true;
         }else{
            $request->session()->put('userdata', 'abbey');
         }

    }
    public function destroySession(){
        if ($request->session()->has('userdata')) {
            setcookie("usercookie", "", time() - 3600, "/");
            $request->session()->flush('userdata');
            return true;
         }else{
            return false;

         }
    }


   //  Not in use yet
    public function generateSession(Request $request){
        if ($request->session()->has('userdata')) {
            // setcookie("usercookie", "", time() - 3600, "/");
            $request->session()->flush('userdata');
            return true;
         }else{
            $request->session()->put('userdata', 'abbey');
            return true;
         }
    }
}
