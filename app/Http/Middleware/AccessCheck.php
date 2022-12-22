<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminMenu;
use App\Http\Resources\ToJsonResource;
use Route;

class AccessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $routeName = Route::current()->getName();
        $response = $this->menuList($request, $routeName);
        if ($response['status'] == 'norecord') {
            $message = [
            "type" => "info",
            "info" => "You do not have access to use this page",
            ];
            return redirect()->route('NoAccess')->with('message', json_encode($message));
        }{
            return $next($request);
        }
      
    }

    public function getUserInfo($id){
        $query = AdminMenu::from('admin_record as t1')
                                ->where('deleted_status', '=', '0')
                                ->where('id', '=', $id)
                                ->get(['t1.personal_id', 't1.role_id', 'lastname', 'firstname', 
                                'othername', 'email_one', 'phone_one'])->first();
        if($query){
            $info = [
                'status' => true,
                'data' => $query,
            ];
            return $info;
        }else{
            $info = [
                'status' => false,
                'data' => '',
            ];
            return $info;
        }
    }
   

    public function menuList($request, $routeName)
    {
        try {
        $returnData = '';
        $result = [];
        $getSession = $request->session()->get('securedata');
        $userid = base64_decode($getSession['userid']);
        $user = $this->getUserInfo($userid);
        $role_id = $user['status']==true ? $user['data']['role_id'] : 0;
        $query = AdminMenu::from('access_permissions as t1')
                    ->where('t1.deleted_status', '=', '0')
                    ->where('t2.status_name', '=', 'Active')
                    ->where('t3.role_id', '=', $role_id)
                    ->where('t1.route_name', '=', $routeName)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('role_permissions as t3', 't3.access_permission_id', '=', 't1.id')
                    ->get(['t1.updated_at'])->first();
       
        if ($query) {
            $info = [
                'status' => 'exist',
                'data' => '',
            ];
            return $info;
        }else{
            $info = [
                'status' => 'norecord',
                'role_id' => $role_id,
                'routeName' => $routeName,
                'data' => '',
            ];
            return $info;

        }
        } catch (Exception $e) {
            return 'no';
        }
    }



}
