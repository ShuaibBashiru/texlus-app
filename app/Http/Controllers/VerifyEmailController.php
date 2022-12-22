<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Resources\ToJsonResource;
use App\Models\VerifyEmailToken;
use App\Models\UnverifiedUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class VerifyEmailController extends Controller
{

   public function index()
   {
           return view('apps.auths.verify_email');
   }

   public function checkID($data){

      $query = UnverifiedUsers::where('email_one', '=', $data['mailTo'])->first();
      if(count($query)>0){
         return true;
      }else{
         return false;
      }
   }

   public function generateRandom(){
      $rand=rand(100000, 999999);
      return $rand;
   }

   public function mailing(VerifyEmailRequest $request){
      try {
         $data = [ 
            "mailSubject" => 'Account verification',
            "title" => 'Verify Your Account Email',
            "msg" => '',
            "descriptions" => '',
            "messageType" => 'Verify email',
            "messageToken" => $this->generateRandom(),
            "mailFrom" => 'yabatechprestigecooperative@gmail.com',
            "mailFromName" => 'Prestige Yabatech',
            "viewName" => 'emailToken',
            "mailTo" => $request->input('email'),
            "mailToName" => $request->input('username'),
            "status_id" => 1,
            "created_by" => 0,
            "expire_date" => date("Y-m-d"),
            "expire_time" => date("h:s:i"),
            "date_created" =>  date("Y-m-d"),
            "time_created" =>  date("h:s:i"),
            "date_modified" =>  date("Y-m-d"),
            "time_modified" =>  date("h:s:i"),
         ];
         if ($this->checkID($data)) {

            $query = VerifyToken::insert($data);

         if ($query) {
         
         if($this->sendMail($data)) {
         $returnData = [
            'title' => 'Successful!',
            'status' => 'success',
            'statusmsg' => 'success',
            'msg' => "Hello, ".$data['mailToName'].". We have sent a notification to the email provided, kindly confirm your token to continue.",
            'userInfo' => ['name' => $data['mailToName'], 'email' => $data['mailTo']],
            'redirect' => '/passwordconfirmation',
         ];
         $dataToJson = new ToJsonResource($returnData);
         return $dataToJson;
               
         }else{
         $returnData = [
            'title' => 'Invalid!',
            'status' => 'failed',
            'statusmsg' => '',
            'msg' => 'Something Went wrong! Please try again later or report this issue on our support page.',
         ];
         $dataToJson = new ToJsonResource($returnData);
         return $dataToJson;
            }
         }else{
         $data = [
            'title' => 'Invalid!',
            'status' => 'failed',
            'statusmsg' => '',
            'msg' => 'Server errror! Please confirm your details, try again or report this issue on our support page.',
         ];
         $dataToJson = new ToJsonResource($data);
         return $dataToJson;
         }
         }else{
         $returnData = [
            'title' => 'Invalid!',
            'status' => 'failed',
            'statusmsg' => '',
            'msg' => 'Oops! The email address provided was not found or has not been registered. Please try again with a registered email Or Create an account.',
         ];
         $dataToJson = new ToJsonResource($returnData);
         return $dataToJson;
         }
        
     } catch (Exception $e) {
         $dataToJson = [
             'title' => 'Server Error!',
             'status' => 'error',
             'msg' => 'Internal server error! Please refresh and try again or report this issue on our support page.',
             "error" => $e->message(),
         ];
         $dataToJson = new ToJsonResource($dataToJson);
         return $dataToJson;
     }
   }


   public function sendMail($data){
      $mailData = [
         'mailSubject' => $data['mailSubject'],
         'title' => $data['title'],
         'to' => $data['mailTo'],
         'toName' => $data['mailToName'],
         'fromName' => $data['mailFromName'],
         'from' => $data['mailFrom'],
         'name' => $data['mailToName'],
         'email' => $data['mailTo'],
         'token' => $data['messageToken'],
         'viewName' => $data['viewName'],
      ];
   Mail::send(new SendMail($mailData));
   if (count(Mail::failures()) < 1) {
      return true;
   }else{
      return false;
   }
   //  return view('mailers.'.$data['viewName'], $data);
      }
}
