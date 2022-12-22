<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use App\Models\HomePages;
use App\Http\Resources\ToJsonResource;
use App\Http\Requests\AuthRequest;
use Cookie;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function index(){
        return view('apps.auths.signin');
    }

    public function login(AuthRequest $request){
        $validator = $request->validated();
        try {
            $email = $request->get('userid');
            $pwd = md5($request->get('pwd'));
            $user = Auth::
                        from('vw_admin_record as t1')
                        ->join('admin_passwords as t2', 't1.id', '=', 't2.userid')
                        ->where('t1.email_one', '=', $email)
                        ->where('t2.pwd_auth_hash', '=', $pwd)
                        ->get(['t1.id', 't1.lastname', 't1.role_id', 't1.file_url', 't1.generated_id', 't1.firstname', 't1.othername', 't1.email_one'])
                        ->first();
                        
            if ($user) {
                $user['generated_id'] = base64_encode(base64_encode($user['generated_id']));
                $getemail = base64_encode($user->email_one);
                $secure = [
                    'useremail' => $getemail,
                ];
                $request->session()->put('authentication', $secure);
                $returnData = [
                    'title' => 'Successful',
                    'status' => 'success',
                    'statusmsg' => 'success',
                    'msg' => "Welcome, $user->firstname. Please wait while you are being redirected.",
                    'redirect' => '/app/auth',
                    'userInfo' => $user,
                ];
                $dataToJson = new ToJsonResource($returnData);
                return $dataToJson;
            }else{
                $returnData = [
                    'title' => 'Invalid!',
                    'status' => 'failed',
                    'statusmsg' => '',
                    'msg' => 'Wrong combination of User ID and Password! Please confirm and try again.',
                ];
                $dataToJson = new ToJsonResource($returnData);
                return $dataToJson;
            }
           
        } catch (Exception $e) {
            $returnData = [
                'title' => 'Server Error!',
                'status' => 'error',
                'msg' => 'Internal server error! Please refresh and try again or report this issue on our support page.',
                "error" => $e->message(),
            ];
            $dataToJson = new ToJsonResource($returnData);
            return $dataToJson;
        }
      
    }

 
}
