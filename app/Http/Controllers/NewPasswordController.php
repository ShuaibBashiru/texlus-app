<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Resources\ToJsonResource;
use App\Models\VerifyToken;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use dateTime;

class NewPasswordController extends Controller
{


   public function checkToken($token, $userid){
      try {
      $query = VerifyToken::from('verification_tokens as t1')
                        ->where('t1._token', '=', $token)
                        ->where('t1.status_id', '<>', 1)
                        ->where('t1.user_email', '=', $userid)
                        ->join('user_record as t2', 't2.email_one', '=', 't1.user_email')
                        ->get(['t1.user_email', 't1._token', 'firstname', 't1.expire_date', 't1.expire_time'])
                        ->first();
      if($query){
         $d = new dateTime();
         $start = strtotime($d->format($query->expire_date.' '.$query->expire_time));
         $end =  strtotime($d->format('Y-m-d h:i:s'));
         $hour = intval(($end - $start)/3600);
         if ($hour >= 2) {
            $data = [
               "status" => false,
               "info" => '',
               "hour" => $hour
            ];
            return $data;
         }else{
            $data = [
               "status" => true,
               "info" => $query,
               "hour" => $hour
            ];
            return $data;
         }
         
      }else{
         $data = [
            "status" => false,
            "info" => '',

         ];
         return $data;
      }
   } catch (Exception $e) {
      return redirect()->route('signin');
   }

}

   public function checkID($data){
      $query = Admin::where('email_one', '=', $data['user_email'])
                        ->get(['id', 'firstname'])
                        ->first();
      if($query){
         $data = [
            "status" => true,
            "info" => $query,
         ];
         return $data;
      }else{
         $data = [
            "status" => false,
            "info" => '',
         ];
         return $data;
      }
   }
   
   public function getRecord($user_email){
      $query = Admin::where('email_one', '=', $user_email)
                        ->get(['id', 'firstname'])
                        ->first();
      if($query){
         $data = [
            "status" => true,
            "info" => $query,
         ];
         return $data;
      }else{
         $data = [
            "status" => false,
            "info" => '',
         ];
         return $data;
      }
   }
 
   public function generateRandom(){
      $rand=rand(100000, 999999);
      return $rand;
   }

   public function fileInfo(){
      $filepath = Storage::path('public/settings/app.json');
      $json = json_decode(file_get_contents($filepath), true);
      $settings = $json;
      return $settings;
  }
  
   public function mailing(Request $request){
      $request->validate([
         'email_one' => 'required|regex:/^[0-9A-Za-z.\-_@]+$/|min:11|max:100|email',
     ]);
      try {
         $fileInfo=$this->fileInfo();
         $d = new dateTime();
         $data = [ 
            "mailSubject" => 'Thanks for signing up!',
            "title" => "Account Activation",
            "msg" => '',
            "descriptions" => '',
            "messageType" => 'Password Reset',
            "_token" => $this->generateRandom(),
            "mailFrom" => $fileInfo['mailing_address'],
            "mailFromName" => $fileInfo['site_name'],
            "user_email" => $request->input('email_one'),
            "mailToName" => '',
            "generated_id" => str_shuffle($d->format('Ymdhis')),
            "expire_date" => date("Y-m-d"),
            "expire_time" => date("h:s:i"),
            "date_created" => date("Y-m-d"),
            "time_created" => date("h:s:i"),
         ];
         $link = request()->getSchemeAndHttpHost().'/password/new/'.base64_encode(base64_encode($data['_token'])).'/'.base64_encode(base64_encode($data['user_email']));
         $info = [ 
            'copyright' => $fileInfo['copyright'],
            'viewName' => 'newAccountPassword',
            'link' => $link,
         ];
         $checkdata = $this->checkID($data);
         if ($checkdata['status']) {
            $data['mailToName'] = $checkdata['info']['firstname'];
            $query = VerifyToken::insert($data);
         if ($query) {
            if($this->sendMail($data, $info)) {
            $returnData = [
               'title' => 'Successful!',
               'status' => 'success',
               'statusmsg' => 'success',
               'msg' => "Hello, ".$data['mailToName'].". A reset link has been sent to the email address provided. Kindly close this page and check your Mail or Spam inbox to continue.",
               'userInfo' => ['name' => $data['mailToName'], 'email' => $data['user_email']],
               'redirect' => "",
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
            "title" => "Invalid",
            "status" => "failed",
            "statusmsg" => "",
            "info" => "",
            'msg' => 'Server errror! Please confirm your details, try again or report this issue on our support page.',
         ];
         $dataToJson = new ToJsonResource($data);
         return $dataToJson;
         }
         }else{
         $returnData = [
            "title" => "Invalid",
            "status" => "failed",
            "statusmsg" => "",
            "info" => "",
            'msg' => 'Oops! The email address provided was not found or has not been registered. Please try again with a registered email Or Create an account.',
         ];
         $dataToJson = new ToJsonResource($returnData);
         return $dataToJson;
         }
        
     } catch (Exception $e) {
         $data = [
            "title" => "Invalid",
            "status" => "server error",
            "statusmsg" => "",
            "info" => "",
            "msg" => "Something went wrong! Please check your network connection and try again or report this error for further assistance.",
            "error" => $e->message()
         ];
         $dataToJson = new ToJsonResource($data);
         return $dataToJson;
     }
   }


   public function sendMail($data, $info){
      $mailData = [
         'mailSubject' => $data['mailSubject'],
         'title' => $data['title'],
         'to' => $data['user_email'],
         'toName' => $data['mailToName'],
         'fromName' => $data['mailFromName'],
         'copyright' => $info['copyright'],
         'from' => $data['mailFrom'],
         'name' => $data['mailToName'],
         'email' => $data['user_email'],
         'token' => $data['_token'],
         'viewName' => $info['viewName'],
         'link' => $info['link'],
         "site_link" => request()->getSchemeAndHttpHost(),

      ];
      // return true;
      Mail::queue(new SendMail($mailData));
      if (count(Mail::failures()) < 1) {
         return true;
      }else{
         return false;
      }
   //  return view('mailers.'.$info['viewName'], $data);
      }

   public function checkPassword($id){
         $query = Admin::from('admin_passwords')->where('userid', '=', $id)
                           ->get(['id'])
                           ->first();
         if($query){
            $data = [
               "status" => true,
               "info" => $query,
            ];
            return $data;
         }else{
            $data = [
               "status" => false,
               "info" => '',
            ];
            return $data;
         }
      }

      public function updateToken($user_email){
         $d = new dateTime();
         $record = [
            'status_id' => 1,
         ];
         $query = Admin::from('verification_tokens')
                              ->where('user_email', '=', $user_email)
                              ->where('_token', '=', $_COOKIE['token'])
                              ->update($record);
         if($query){
            $data = [
               "status" => true,
            ];
            return $data;
         }else{
            $data = [
               "status" => false,
            ];
            return $data;
         }
      }
public function changePassword(Request $request){
      try {
          $exist = false;
          $failed = false;
          $successful = false;
          $d = new dateTime();
          $generated_id = str_shuffle($d->format('Ymdhis'));
          $user_email = $request->input('user_email');
          $user_record = $this->getRecord($user_email);
          $userid = $user_record['status'] ? $user_record['info']['id'] : 0;
          $record = [
              "userid" => $userid,
              "generated_id" => $generated_id,
              "pwd_auth_hash" => md5($request->input('pwd')),
              "pwd_auth" => $request->input('pwd'),
              "date_created" => $d->format('Y-m-d'),
              "time_created" => $d->format('h:i:s'),
              "updated_at" => $d->format("Y-m-d h:i:s"),
          ];
          $checkPassword = $this->checkPassword($userid);
            if ($checkPassword['status']) {
               unset($record['generated_id']);
               unset($record['userid']);
               $query = Admin::from('admin_passwords')
                                 ->where('userid', '=', $userid)
                                 ->update($record);
            }else{
               $query = Admin::from('admin_passwords')->insert($record);
            }
            $updateToken = $this->updateToken($user_email);
            if ($query && $updateToken['status']) {
            $successful = true;
            }else{
            $failed = true;
            }
  
          if ($successful) {
              $returnData = [
                  "title" => "Successful",
                  "status" => "success",
                  "statusmsg" => "success",
                  "msg" => "New password has ben created successfully, now redirecting...",
                  "redirect" => "/signin",
              ];
          }else{
              $returnData = [
                  "title" => "Invalid",
                  "status" => "failed",
                  "statusmsg" => "",
                  "msg" => "Error processing request! Please refresh and try again or report this error for further assistance.",
              ];
          }
  
          $dataToJson = new ToJsonResource($returnData);
          return $dataToJson;
  
  
      } catch (Exception $e) {
          $returnData = [
              "title" => "Invalid",
              "status" => "server error",
              "statusmsg" => "",
              "msg" => 'Something went wrong! Please check your network connection and try again or report this error for further assistance.',
              "error" => $e->message()
          ];
          $dataToJson = new ToJsonResource($returnData);
          return $dataToJson;
      }
  
      }


}
