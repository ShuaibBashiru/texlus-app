<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use Illuminate\Http\Request;
use App\Models\HomePages;
use App\Http\Resources\ToJsonResource;
use App\Http\Requests\AuthRequest;
use Cookie;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function index(Request $request){
            return view('apps.auths.authentication');
    }
    
    public function access(Request $request){
        $getSession = $request->session()->get('authentication');
        $useremail = base64_decode($getSession['useremail']);
        $authenticate = $this->authenticate($request, $useremail);
        if ($authenticate['status']) {
            $returnData = [
                'title' => 'Successful',
                'status' => 'success',
                'statusmsg' => 'success',
                'msg' => "",
                'redirect' => '/'.$authenticate['redirect'],
                'userInfo' => '',
            ];
            $dataToJson = new ToJsonResource($returnData);
            return $dataToJson;
        }else{
            $returnData = [
                'title' => 'Invalid!',
                'status' => 'failed',
                'statusmsg' => '',
                'msg' => $authenticate['msg'],
                'userInfo' => '',
            ];
            $message = json_encode($authenticate['msg']);
            return view('apps.auths.authenticationFailure', compact('message'));
        }
    }

    public function getHomePage($role_id){
        $query = HomePages::from('landing_page as t1')
                                    ->where('role_id', '=', $role_id)
                                    ->leftJoin('access_permissions as t2', 't2.id', '=', 't1.access_permission_id')
                                    ->get(['t2.route_name', 't2.routeLink'])->first();
        if($query){
            $data=[
                'status'=> true,
                'data'=> $query,
            ];
            return $data;
        }else{
            $data=[
                'status'=> false,
                'data'=> '',
            ];
            return $data;
        }
    }

    public function authenticate($request, $email){
        try {
            $user = Auth::
                        from('vw_admin_record as t1')
                        ->join('admin_passwords as t2', 't1.id', '=', 't2.userid')
                        ->where('t1.email_one', '=', $email)
                        ->get(['t1.id', 't1.lastname', 't1.role_id', 't1.file_url', 't1.generated_id', 't1.firstname', 't1.othername', 't1.email_one'])
                        ->first();
                        
            if ($user) {
                $getid = base64_encode($user->id);
                $getemail = base64_encode($user->email_one);
                $role_id = base64_encode($user->role_id);
                $checkHomePage = $this->getHomePage($user->role_id);
                $homepage =  $checkHomePage['status'] ? $checkHomePage['data']['routeLink'] : 'noaccess';
                $user['generated_id'] = base64_encode(base64_encode($user['generated_id']));
                $secure = [
                    'userid' => $getid,
                    'role_id' => $role_id,
                    'useremail' => $getemail,
                    'generated_id' => $user['generated_id'],
                ];
                $cookie_name = "usercookie";
                $cookie_value = $getid;
                setcookie($cookie_name, $cookie_value, time() + (86400), "/");
                $request->session()->put('securedata', $secure);
                $request->session()->put('userdata', $user);
                $data=[
                    'status'=> true,
                    'redirect' => $homepage,
                    'msg' => '',

                ];
                return $data;
            }else{
                $data=[
                    'status'=> false,
                    'redirect' =>'',
                    'msg' => 'Something went wrong while authenticating your account. 
                    Please log in again or report this error using one of our support channels.',
                ];
                return $data;
            }
           
        } catch (Exception $e) {
            $data=[
                'status'=> false,
                'redirect' =>'',
                'msg' => 'Server Error! Something went wrong while authenticating your account. 
                    Please log in again or report this error using one of our support channels.',
            ];
            return $data;

        }
      
    }

 
}
