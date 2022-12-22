<?php

namespace App\Http\Controllers;
use App\Models\RolePermissions;
use App\Models\HomePages;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use dateTime;
use PDF;

class RolePermissionsController extends Controller
{
    
    public function list($id){
        $cookie_name = "manageUser";
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->role_record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.role_permissions.record', compact('record'));
        }else{
            $message = json_encode("No record found");
            return redirect()->route('list_rolepermission')->with('message', json_encode($message));
        }
    }

    public function role_record($id)
    {

        try {
        $returnData = '';
        $result = [];
        $query = Role::from('roles as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->get(['t1.role_name', 't1.id', 't1.id', 't1.generated_id', 't1.updated_at'])->first();

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
    
    public function rolePermission($id){
        $query = RolePermissions::from('role_permissions as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.role_id', '=', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->orderBy('t1.role_id', 'DESC')
                    ->pluck('t1.access_permission_id')->toArray();
       
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

    public function record($id)
    {
        try {
        $returnData = '';
        $result = [];
        $query = RolePermissions::from('access_permissions as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('access_group as t3', 't3.id', '=', 't1.group_id')
                    ->leftJoin('role_permissions as t4', 't4.id', '=', 't1.group_id')
                    ->leftJoin('roles as t5', 't5.id', '=', 't4.role_id')
                    ->get(['t1.routeLink', 't4.id', 't3.group_name', 't5.role_name', 't2.status_name', 't1.descriptions', 't4.generated_id', 't1.updated_at'])->first();

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


    public function listAll(Request $request)
    {
        try {
        $returnData = '';
        $result = [];
        $id = $request->input('role_id');
        $query = RolePermissions::from('access_permissions as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t2.status_name', '=', 'Active')
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('access_group as t3', 't3.id', '=', 't1.group_id')
                    ->get(['t1.routeLink', 't1.title', 't1.descriptions', 't1.date_created',
                    't1.status_id', 't1.id', 't3.group_name', 't2.status_name',
                    't1.generated_id', 't1.updated_at']);

        if (count($query)>0) {
             // 
            $rolePermissions = $this->rolePermission($id);
            $returnData = [
                "title" => "Successful",
                "status" => "success",
                "statusmsg" => "success",
                "msg" => "",
                "redirect" => "",
                "info" => $query,
                "rolePermissions" => $rolePermissions['data'],
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
        $query = RolePermissions::where('deleted_status', '=', '0')
                                    ->where('role_id', '=', $data['role_id'])
                                    ->where('access_permission_id', '=', $data['access_permission_id'])
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }  


    public function assign(Request $request){
        try {
            $records = [];
            $exist = [];
            $noRecord = [];
            $failed = [];
            $successful = [];
            $updatedRecord = [];
            $count = 0;
            $data = $request->input('records');
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $record = [
                "role_id" => $request->input('role_id'),
                "access_permission_id" => '',
                "created_by" => base64_decode($getSession['userid']),
                "generated_id" => '',
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];

        $list = $request->input('selectedList');
        foreach ($list as $id) {
            $record['generated_id'] = str_shuffle($d->format('Ymdhis'));
            $record['access_permission_id'] = $id;
            array_push($records, $record);
            if($this->checkIfRecordExist($record)){
                array_push($exist, $record);
            }else{
                $query = RolePermissions::insert($record);
                if ($query) {
                    array_push($successful, $record);
                }else{
                    array_push($failed, $record);
                }
            }
            }
            // End loop
            $choiceOfSentence = count($successful) > 1 ? "records were" : "record was";
            if (count($successful) == count($records)) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "The selected {$choiceOfSentence} successfully created.",
                    "redirect" => "",
                    "totalRecord" => $records,
                    "successful" => $successful,
                    "failed" => $failed,
                    "exist" => $exist,
                    "noRecord" => $noRecord,
                ];
            } else if (count($updatedRecord) == count($records)) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "The selected {$choiceOfSentence} successfully updated.",
                    "redirect" => "",
                    "total" => $records,
                    "successful" => $updatedRecord,
                    "failed" => $failed,
                    "exist" => $exist,
                    "noRecord" => $noRecord,
                ];
            } else if(count($successful) > 0) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "The selected {$choiceOfSentence} successfully updated.",
                    "redirect" => "",
                    "total" => $records,
                    "successful" => $successful,
                    "failed" => $failed,
                    "exist" => $exist,
                    "noRecord" => $noRecord,
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
                    "exist" => $exist,
                    "noRecord" => $noRecord,
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

    public function remove(Request $request){
            try {
                $records = [];
                $exist = [];
                $noRecord = [];
                $failed = [];
                $successful = [];
                $updatedRecord = [];
                $count = 0;
                $data = $request->input('records');
                $getSession = $request->session()->get('securedata');
                $d = new dateTime();
                $record = [
                    "role_id" => $request->input('role_id'),
                    "access_permission_id" => '',
                    "created_by" => base64_decode($getSession['userid']),
                    "generated_id" => '',
                    "date_created" => $d->format('Y-m-d'),
                    "time_created" => $d->format('h:i:s'),
                    "updated_at" => $d->format("Y-m-d h:i:s"),
                ];
    
            $list = $request->input('selectedList');
            foreach ($list as $id) {
                $record['generated_id'] = str_shuffle($d->format('Ymdhis'));
                $record['access_permission_id'] = $id;
                array_push($records, $record);
                if($this->checkIfRecordExist($record)){
                    $query = RolePermissions::
                                            where('access_permission_id', $id)
                                            ->where('role_id', $record['role_id'])
                                            ->delete();
                    if ($query) {
                            array_push($successful, $record);
                    }else{
                            array_push($failed, $record);
                    }
                }else{
                    array_push($noRecord, $record);
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
                        "exist" => $exist,
                        "noRecord" => $noRecord,
                    ];
                } else if (count($updatedRecord) == count($records)) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "The selected {$choiceOfSentence} successfully updated.",
                        "redirect" => "",
                        "total" => $records,
                        "successful" => $updatedRecord,
                        "failed" => $failed,
                        "exist" => $exist,
                        "noRecord" => $noRecord,
                    ];
                } else if(count($successful) > 0) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "The selected {$choiceOfSentence} successfully updated.",
                        "redirect" => "",
                        "total" => $records,
                        "successful" => $successful,
                        "failed" => $failed,
                        "exist" => $exist,
                        "noRecord" => $noRecord,
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
                        "exist" => $exist,
                        "noRecord" => $noRecord,
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


    public function checkIfHomeExist($data){
                $query = HomePages::where('deleted_status', '=', '0')
                                            ->where('role_id', '=', $data['role_id'])
                                            ->get()->first();
                if($query){
                    return true;
                }else{
                    return false;
                }
            }  

   public function assignHomePage(Request $request){
                try {
                    $records = [];
                    $exist = [];
                    $noRecord = [];
                    $failed = [];
                    $successful = [];
                    $updatedRecord = [];
                    $count = 0;
                    $data = $request->input('records');
                    $getSession = $request->session()->get('securedata');
                    $d = new dateTime();
                    $record = [
                        "role_id" => $request->input('role_id'),
                        "access_permission_id" => $request->input('access_permission_id'),
                        "created_by" => base64_decode($getSession['userid']),
                        "generated_id" => str_shuffle($d->format('Ymdhis')),
                        "date_created" => $d->format('Y-m-d'),
                        "time_created" => $d->format('h:i:s'),
                        "updated_at" => $d->format("Y-m-d h:i:s"),
                    ];
                    if($this->checkIfHomeExist($record)){
                        array_push($exist, $record);
                        $query = HomePages::where('role_id', '=', $record['role_id'])
                                            ->update($record);
                        if ($query) {
                            $successful = true;
                        }else{
                            $failed = true;
                        }
                    }else{
                        $query = HomePages::insert($record);
                        if ($query) {
                            $successful = true;
                        }else{
                            $failed = true;
                        }
                    }
    
                if ($successful) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "Successfully created, now redirecting...",
                        "redirect" => "list",
                    ];
                }else{
                    $returnData = [
                        "title" => "Invalid",
                        "status" => "failed",
                        "statusmsg" => "",
                        "msg" => "This record could not be created/updated right now! Please refresh and try again or report this error for further assistance.",
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
