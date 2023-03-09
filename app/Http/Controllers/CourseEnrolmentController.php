<?php

namespace App\Http\Controllers;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;
use Closure;
use Session;
class CourseEnrolmentController extends Controller
{
    public function post_landing($category, $title){
        return view('apps.landing.post');
    }
    
    public function course_landing(Request $request, $category, $title){
               //Check if session exist
               if ($request->session()->has('adminSessionData')) {
                    $request->session()->forget('ActiveUrl');
                    $record = $this->record($category, $title);
                    if ($record['status']=='success') {
                        $record = $record['info'];
                        return view('apps.landing.course', compact('record'));
                    }else{
                        $message = [
                            "type" => "",
                            "info" => "The item you are trying to access no longer available.",
                        ];
                        return redirect()->route('home')->with('message', json_encode($message));
                    }

             }else{
                //  Save URL to session
                $url = $request->url();
                $request->session()->put('ActiveUrl', $url);
                $message = [
                    "type" => "info",
                    "info" => "You may need to log in before you continue. <a href='/signin'>Log in</a> or <a href='/signup'>Create an account</a>",
                 ];
                 $record = $this->record($category, $title);
                 $record = $record['info'];
                 return view('apps.landing.course', compact('record'))->with('message', json_encode($message));
             }
    }

    public function checkIfNotEnrolled(Request $request, $id){



    }

    public function order_item(Request $request, $id){
        if ($request->session()->has('adminSessionData')) {
            return view('apps.landing.course');
         }else{
            $message = [
                "status" => "info",
                "msg" => "Kindly log in or sign up to continue. <a href='/signin'>Log in</a>",
             ];
             $dataToJson = new ToJsonResource($message);
             return $dataToJson;
         }
        
    }

    public function record($category, $title)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Courses::from('vw_courses as t1')
                        ->where('t1.deleted_status', '=', 0)
                        ->where('t1.status_name', '=', 'Active')
                        ->where('t1.category_name', $category)
                        ->where('t1.item_title', $title)
                        ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                        ->get(['t1.*'])->first();

        if ($query) {
            $query['generated_id'] = base64_encode(base64_encode($query['generated_id']));
            $returnData = [
                "title" => "Successful",
                "status" => "success",
                "statusmsg" => "success",
                "msg" => "",
                "redirect" => "",
                "info" => $query,
            ];

        }else{
            $returnData = [
                "title" => "Invalid",
                "status" => "norecord",
                "statusmsg" => "",
                "msg" => "No record(s) found.",
                "info" =>"",

            ];

        }
        $dataToJson = new ToJsonResource($returnData);
        return $dataToJson;
        } catch (Exception $e) {
            $returnData = [
                "title" => "Invalid",
                "status" => "server error",
                "statusmsg" => "",
                "msg" => "Something went wrong! Please check your network connection and try again or report this error for further assistance.",
                "error" => $e->message()
            ];
            $dataToJson = new ToJsonResource($returnData);
            return $dataToJson;
        }
    }



}
