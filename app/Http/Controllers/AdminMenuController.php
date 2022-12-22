<?php

namespace App\Http\Controllers;
use App\Models\AdminMenu;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class AdminMenuController extends Controller
{
    
    public function manage($id){
        $cookie_name = "manageUser";
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.admin_menu.manage', compact('record'));
        }else{
            $message = json_encode("No record found");
            return redirect()->route('list_adminmenu')->with('message', json_encode($message));
        }
    }

    public function list(){
        return view('apps.admin_menu.record');
    }

    public function uploadBatch(){
        return view('apps.admin_menu.upload_record');
    }

    public function createRecord(){
        return view('apps.admin_menu.new_record');
    }

    public function checkIfIdIsValid($data){
        $query = AdminMenu::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $data['personal_id'])
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
   
    public function record($id)
    {
        try {
        $returnData = '';
        $result = [];
        $query = AdminMenu::from('admin_app_menu as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('admin_app_menu_group as t3', 't3.id', '=', 't1.group_id')
                    ->leftJoin('access_permissions as t4', 't4.id', '=', 't1.access_permission_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t4.title as menu_title', 't1.access_permission_id', 't1.link_target', 't3.group_name', 
                    't4.routeLink', 't4.descriptions', 't3.group_icon', 't1.descriptions', 't1.date_created', 
                    't1.status_id', 't1.group_id', 't1.id', 't2.status_name', 't1.generated_id', 't1.updated_at'])->first();
        
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

    public function listAll()
    {
        try {
        $returnData = '';
        $result = [];
        $query = AdminMenu::from('admin_app_menu as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('admin_app_menu_group as t3', 't3.id', '=', 't1.group_id')
                    ->leftJoin('access_permissions as t4', 't4.id', '=', 't1.access_permission_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t4.title as menu_title', 't1.group_id', 't1.access_permission_id', 't1.link_target', 't3.group_name', 't4.routeLink', 't4.descriptions', 't3.group_icon', 't1.descriptions', 
                    't1.date_created', 't1.status_id', 't1.id', 't2.status_name', 't1.generated_id', 
                    't1.updated_at']);
       
        if (count($query) > 0) {
             // 
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
   

    public function menuList(Request $request)
    {
        try {
        $returnData = '';
        $result = [];
        $getSession = $request->session()->get('securedata');
        $userid = base64_decode($getSession['userid']);
        $user = $this->getUserInfo($userid);
        $role_id = $user['status']==true ? $user['data']['role_id'] : 0;
        $query = AdminMenu::from('admin_app_menu as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t2.status_name', '=', 'Active')
                    ->where('t5.role_id', '=', $role_id)
                    ->where('t3.menu_bar', 'Admin Sidebar')
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('admin_app_menu_group as t3', 't3.id', '=', 't1.group_id')
                    ->leftJoin('access_permissions as t4', 't4.id', '=', 't1.access_permission_id')
                    ->join('role_permissions as t5', 't5.access_permission_id', '=', 't1.access_permission_id')
                    ->orderBy('t1.id', 'ASC')
                    ->get(['t4.title as menu_title', 't1.group_id', 't1.access_permission_id', 't1.link_target', 't3.group_name', 't4.routeLink', 't4.descriptions', 't3.group_icon', 't1.descriptions', 
                    't1.date_created', 't1.status_id', 't1.id', 't2.status_name', 't1.generated_id', 
                    't1.updated_at']);
       
        if (count($query) > 0) {
             // 
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



    public function checkIfRecordExist($data){
        $query = AdminMenu::where('deleted_status', '=', '0')
                                ->where('menu_title', '=', $data['menu_title'])
                                ->where('group_id', '=', $data['group_id'])
                                ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
   

    public function create(Request $request){
       $request->validate([
            'access_permission_id' => 'required|max:100|min:1',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $record = [
                "generated_id" => $generated_id,
                "group_id" => $request->input('group_id'),
                "link_target" => strtolower($request->input('link_target')),
                "access_permission_id" => $request->input('access_permission_id'),
                "created_by" => base64_decode($getSession['userid']),
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $query = AdminMenu::insert($record);
                if ($query) {
                $successful = true;
                }else{
                $failed = true;
                }
    
            if ($successful) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "New record has been successfully created, now redirecting...",
                    "redirect" => "list",
                ];
            }else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This record could not be created right now! Please refresh and try again or report this error for further assistance.",
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


    public function update_record(Request $request){
        $request->validate([
            'access_permission_id' => 'required|max:100|min:1',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "group_id" => $request->input('group_id'),
                "link_target" => strtolower($request->input('link_target')),
                "access_permission_id" => $request->input('access_permission_id'),
                "created_by" => base64_decode($getSession['userid']),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $update = AdminMenu::
                                where('generated_id', '=', $id)
                                    ->update($record);
                if ($update) {
                $successful = true;
                }else{
                $failed = true;
                }
    
            if ($successful) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "The record was successfully updated, please wait a moment while reloading the changes you made.",
                    "redirect" => "",
                ];
            } else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This record could not be updated! Please refresh and try again.",
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

//  Manage batch status
public function status_update_batch(Request $request)
{
try {
    $records = [];
    $exist = [];
    $noRecord = [];
    $failed = [];
    $successful = [];
    $count = 0;
    $getSession = $request->session()->get('securedata');
    $d = new dateTime();
    $row = [
        "modified_by" => base64_decode($getSession['userid']),
        "status_id" => $request->input('status'),
    ];
    $list = $request->input('selectedList');
    foreach ($list as $id) {
    array_push($records, $row);
    $newid = $id;
    $update = AdminMenu::where('generated_id', '=', $newid)
                            ->where('status_id', '<>', $row['status_id'])
                                ->update($row);

    if ($update) {
        array_push($successful, $row);
        }else{
        array_push($failed, $row);
        }
    }
// End loop
    $choiceOfSentence = count($successful) > 1 ? "records were" : "record was";
    if (count($successful) == count($records)) {
        $returnData = [
            "title" => "Successful",
            "status" => "success",
            "statusmsg" => "success",
            "msg" => "The selected {$choiceOfSentence} successfully updated.",
            "redirect" => "",
            "totalRecord" => $records,
            "successful" => $successful,
            "failed" => $failed,
        ];
    } else if(count($successful) > 0) {
        $returnData = [
            "title" => "Successful",
            "status" => "success",
            "statusmsg" => "success",
            "msg" => "The selected {$choiceOfSentence} successfully updated.",
            "redirect" => "",
            "totalRecord" => $records,
            "successful" => $successful,
            "failed" => $failed,
        ];
    }else{
        $returnData = [
            "title" => "Invalid",
            "status" => "failed",
            "statusmsg" => "",
            "msg" => "The selected record(s) could not be processed. This may be that this action has already been taken on the selected record(s), kindly confirm the status before you continue.",
            "totalRecord" => $records,
            "successful" => $successful,
            "failed" => $failed,
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

    public function manage_status(Request $request)
    {
    try {
        $exist = false;
        $noRecord = false;
        $failed = false;
        $successful = false;
        $getSession = $request->session()->get('securedata');
        $d = new dateTime();
        $row = [
            "modified_by" => base64_decode($getSession['userid']),
            "status_id" => $request->input('status'),
        ];
        $id = base64_decode(base64_decode($request->input('id')));
        $update = AdminMenu::where('generated_id', '=', $id)
                            ->update($row);
    
        if ($update) {
            $successful=true;
            }else{
            $failed=true;
            }
    
    if ($successful) {
        $returnData = [
            "title" => "Successful",
            "status" => "success",
            "statusmsg" => "success",
            "msg" => "This record has been successfully updated. Reloading....",
            "redirect" => "",
        ];
    }else{
        $returnData = [
            "title" => "Invalid",
            "status" => "failed",
            "statusmsg" => "",
            "msg" => "This record could not be updated, kindly confirm the status before you continue.",
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


public function checkBeforeDelete($id, $status){
$query = AdminMenu::where('generated_id', '=', $id)
                        ->where('deleted_status', '=', $status)
                        ->get(['id'])->first();
    if ($query) {
    return true;
    }else{
    return false;
    }
}
// Trash or delete an item
public function trash(Request $request)
    {
    try {
        $deleted = false;
        $failed = false;
        $successful = false;
        $getSession = $request->session()->get('securedata');
        $d = new dateTime();
        $id = base64_decode(base64_decode($request->input('id')));
        $row = [
            "deleted_by" => base64_decode($getSession['userid']),
            "deleted_status" => 1,
            "access_permission_id" => '0'.$request->input('access_permission_id'),
            "group_id" => '0'.$request->input('group_id'),
        ];
        
    if ($this->checkBeforeDelete($id, 0)) {
        $update = AdminMenu::where('generated_id', '=', $id)
                                ->update($row);
        if ($update) {
            $successful = true;
        }else{
            $failed = true;
        }
    }else{
        $deleted = true;
        }

    if ($successful) {
            $returnData = [
                "title" => "Successful",
                "status" => "success",
                "statusmsg" => "success",
                "msg" => "The record has been deleted successfully, please wait while you are being redirected.",
                "redirect" => '../list'
            ];
        }else if($deleted) {
            $returnData = [
                "title" => "Exist",
                "status" => "failed",
                "statusmsg" => "success",
                "msg" => "The record is no longer available, please refresh and confirm before you continue.",
                "redirect" => "",
            ];
        } else{
            $returnData = [
                "title" => "Invalid",
                "status" => "failed",
                "statusmsg" => "",
                "msg" => "There was an error processing this request, please refresh and try again or report this error for further assistance.",
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
