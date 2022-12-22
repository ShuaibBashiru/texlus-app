<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminRequestBatch;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class AdminController extends Controller
{
    
    public function manage($id){
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        $cookie_name = "manageUser";
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.admin.manage', compact('record'));
        }else{
            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }

    public function profile($id){
        $id = base64_decode(base64_decode($id));
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.admin.profile', compact('record'));
        }else{
            $message = [
                "type" => "error",
                "info" => "Something went wrong! refresh and continue.",
             ];
            return redirect()->route('dashboard')->with('message', json_encode($message));
        }

    }

    public function edit_name($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_name', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }
    public function edit_dob($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_dob', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }
    public function edit_gender($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_gender', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }
    public function edit_contact_address($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_contact_address', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }

    public function edit_phone($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_phone', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }
 
    public function edit_password($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
            $id = base64_decode(base64_decode($id));
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.admin.edit_password', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_admin')->with('message', json_encode($message));
            }
        }else{

            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_admin')->with('message', json_encode($message));
        }
    }

    public function list(){
        return view('apps.admin.record');
    }

    public function uploadBatch(){
        return view('apps.admin.upload_record');
    }

    public function createRecord(){
        return view('apps.admin.new_record');
    }

    public function checkIfIdIsValid($data){
        $query = Admin::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $data['personal_id'])
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function getData($userid){
        $query = Admin::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $userid)
                                    ->get(['id'])->first();
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
        $query = Admin::from('admin_record as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('genders as t3', 't3.id', '=', 't1.gender_id')
                    ->leftJoin('countries as t4', 't4.id', '=', 't1.country_id')
                    ->leftJoin('states as t5', 't5.id', '=', 't1.state_id')
                    ->leftJoin('admin_passport as t6', 't6.userid', '=', 't1.id')
                    ->leftJoin('roles as t7', 't7.id', '=', 't1.role_id')
                    ->get(['t1.personal_id', 't1.role_id', 't7.role_name', 'lastname', 'firstname', 
                    'othername', 'email_one', 'email_two', 'phone_one', 'phone_two', 'phone_code', 
                    'date_of_birth', 't1.country_id', 't1.state_id', 't4.country_name', 't5.state_name', 
                    'address_one', 'dob', 'mob', 'yob', 't1.date_created', 'gender_name', 'gender_id', 't2.status_name', 
                    'address_one', 't6.file_url', 't6.file_name', 't1.generated_id', 't1.updated_at'])->first();

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
        $query = Admin::from('vw_admin_record as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('genders as t3', 't3.id', '=', 't1.gender_id')
                    ->leftJoin('roles as t4', 't4.id', '=', 't1.role_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t1.personal_id', 't1.role_id', 't4.role_name', 'lastname', 'firstname', 'othername', 
                    'email_one', 'phone_code', 'phone_one', 'date_of_birth', 't1.date_created', 
                    'gender_name as gender_id', 'createdByName', 't1.status_id', 't2.status_name', 't1.generated_id', 't1.updated_at']);
       
        if (count($query) > 0) {
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
        $query = Admin::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $data['personal_id'])
                                    ->orWhere('email_one', '=', $data['email_one'])
                                    ->orWhere('phone_one', '=', $data['phone_one'])
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function upload(AdminRequestBatch $request){
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
                "personal_id" => '',
                "lastname" => '',
                "firstname" => '',
                "othername" => '',
                "email_one" => '',
                "phone_code" => '',
                "phone_one" => '',
                "dob" => '00',
                "mob" => '00',
                "yob" => '0000',
                "date_of_birth" => '',
                "gender_id" => '',
                "created_by" => base64_decode($getSession['userid']),
                "generated_id" => '',
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
        foreach ($data as $row) {
            $record['generated_id'] = str_shuffle($d->format('Ymdhis'));
            $record['personal_id'] = strtoupper($row['personal_id']);
            $record['lastname'] = ucfirst(strtolower($row['lastname']));
            $record['firstname'] = ucfirst(strtolower($row['firstname']));
            $record['othername'] = ucfirst(strtolower($row['othername']));
            $record['email_one'] = strtolower($row['email_one']);
            $record['phone_code'] = '+'.$row['phone_code'];
            $record['gender_id'] = $row['gender_id'];
            $record['phone_one'] = (strpos($row['phone_one'], '0')===0) ? substr($row['phone_one'], 1) : $row['phone_one'];
            $record['date_of_birth'] = $row['date_of_birth'];
            $date_of_birth = explode('/', $row['date_of_birth']);
            $record['dob'] = $date_of_birth[0];
            $record['mob'] = $date_of_birth[1];
            $record['yob'] = $date_of_birth[2];
            $status = [
                "upload_status" => ""
            ];
            array_merge($row, $status);
            array_push($records, $row);
            if($this->checkIfRecordExist($record)){
                $row['upload_status'] = 'Exist';
                array_push($exist, $row);
            }else{
                $query = Admin::insert($record);
                if ($query) {
                $row['upload_status'] = 'Successful';
                array_push($successful, $row);
                }else{
                $row['upload_status'] = 'Failed';
                array_push($failed, $row);
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
                "msg" => "Uploaded but some of the record(s) could not be processed. This may be that such record(s) already uploaded, kindly confirm the record(s) before you continue.",
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
                "msg" => "The record(s) could not be processed. This may be that the selected record(s) already uploaded, kindly confirm the record(s) before you continue.",
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

    public function create(AdminRequest $request){
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $personal_id  =strtoupper($request->input('personal_id'));
            $dob = $request->input('dob') == '' ? '00' : $request->input('dob');
            $mob = $request->input('mob') == '' ? '00' : $request->input('mob');
            $yob = $request->input('yob') == '' ? '0000' : $request->input('yob');
            $record = [
                "personal_id" => $personal_id == '' ? $generated_id : $personal_id,
                "generated_id" => $generated_id,
                "lastname" => ucfirst(strtolower($request->input('lastname'))),
                "firstname" => ucfirst(strtolower($request->input('firstname'))),
                "othername" => ucfirst(strtolower($request->input('othername'))),
                "phone_one" => $request->input('phone_one'),
                "email_one" => strtolower($request->input('email_one')),
                "gender_id" => $request->input('gender_id'),
                "dob" => $dob,
                "mob" => $mob,
                "yob" => $yob,
                "date_of_birth" => $dob.'/'.$mob.'/'.$yob,
                "created_by" => base64_decode($getSession['userid']),
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $query = Admin::insert($record);
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


    public function update_name(Request $request){
        $request->validate([
            'generated_id' => 'required',
            'lastname' => 'required',
            'firstname' => 'required',
            'othername' => 'nullable',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "firstname" => ucfirst(strtolower($request->input('firstname'))),
                "othername" => ucfirst(strtolower($request->input('othername'))),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $update = Admin::where('generated_id', '=', $id)
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
    public function update_dob(Request $request){
        $request->validate([
            'generated_id' => 'required|string|max:30|min:6',
            'dob' => 'nullable|numeric',
            'mob' => 'nullable|numeric',
            'yob' => 'nullable|numeric',
        ]);

        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $dob = $request->input('dob');
            $mob = $request->input('mob');
            $yob = $request->input('yob');
            $record = [
                "dob" => $dob,
                "mob" => $mob,
                "yob" => $yob,
                "date_of_birth" => $dob.'/'.$mob.'/'.$yob,
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $update = Admin::where('generated_id', '=', $id)
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

    public function update_gender(Request $request){
        $request->validate([
            'generated_id' => 'required|string|max:30|min:6',
            'gender_id' => 'required|numeric',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "gender_id" => $request->input('gender_id'),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $update = Admin::where('generated_id', '=', $id)
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

    public function checkIfPhoneExist($data, $id){
        $query = Admin::where('deleted_status', '=', '0')
                                    ->where('phone_one', '=', $data['phone_one'])
                                    ->where('generated_id', '<>', $id)
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function update_phone(Request $request){
        $request->validate([
            'generated_id' => 'required|string|max:30|min:6',
            'phone_code' => 'required',
            'phone_one' => 'required|numeric',
            'phone_two' => 'nullable|numeric',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "phone_one" => $request->input('phone_one'),
                "phone_two" => $request->input('phone_two'),
                "phone_code" => $request->input('phone_code'),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
            if ($this->checkIfPhoneExist($record, $id)) {
                $exist = true;
            }else{
                $update = Admin::
                where('generated_id', '=', $id)
                    ->update($record);
                if ($update) {
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
                    "msg" => "The record was successfully updated, please wait a moment while reloading the changes you made.",
                    "redirect" => "",
                ];
            } else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This record could not be updated! this may be that the first Phone number provided already taken for another user. Please confirm and try again.",
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

    public function update_contact_address(Request $request){
        $request->validate([
            'generated_id' => 'required|string|max:30|min:6',
            'country_id' => 'required|numeric',
            'state_id' => 'required|numeric',
            'address_one' => 'nullable|string',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "country_id" => $request->input('country_id'),
                "state_id" => $request->input('state_id'),
                "address_one" => $request->input('address_one'),
                "modified_by" => base64_decode($getSession['userid']),

            ];
                $update = Admin::where('generated_id', '=', $id)
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
    $update = Admin::where('generated_id', '=', $newid)
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


    public function update_role(Request $request)
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
             
            
            "role_id" => $request->input('role'),
        ];
        $id = base64_decode(base64_decode($request->input('id')));
        $update = Admin::where('generated_id', '=', $id)
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
        $update = Admin::where('generated_id', '=', $id)
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
$query = Admin::where('generated_id', '=', $id)
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
            "personal_id" => 'deleted::'.$request->input('personal_id'),
            "email_one" => 'deleted::'.$request->input('email_one'),
            "phone_one" => 'deleted::'.$request->input('phone_one'),
        ];
        
    if ($this->checkBeforeDelete($id, 0)) {
        $update = Admin::where('generated_id', '=', $id)
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


public function fileInfo(){
    $filepath = Storage::path('public/settings/app.json');
    $json = json_decode(file_get_contents($filepath), true);
    $settings = $json;
    return $settings;
}



public function profilePdf($id){
    $id = base64_decode(base64_decode($id));
    $record = $this->record($id);
    $d = new dateTime();
    $fileInfo=$this->fileInfo();
    $timeseries = str_shuffle($d->format('Ymdhis'));
    $upload_file = $record['info']['lastname'].'_'.$record['info']['firstname']
    .'_'.$record['info']['personal_id'];
    $base = base_path();
    $passport_dir = base_path().'/public/storage/passports/admin/';
    $logo_dir = base_path().'/public/storage/media/logo/';
    $filepath = $passport_dir.$record['info']['file_name'];
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);
    $image = base64_encode(file_get_contents($filepath));
    $getlogofile = explode('/', $fileInfo['logo_link']);
    $logo = base64_encode(file_get_contents($logo_dir.end($getlogofile)));
    $data = [
        "dated" => $d->format('d-m-Y'),
        "title" => "Account Profile",
        "headerName" => $fileInfo['site_name'],
        "site_logo" => $logo,
        "owner" => $fileInfo['site_name'],
        "copyright" => $fileInfo['copyright'],
        "user_info" => $record['info'],
        "user_image" => $image,
    ];
    $upload_file = $data['title'].'_'.$record['info']['lastname'].'_'.$record['info']['firstname']
    .'_'.$record['info']['personal_id'];

    // return view('apps.account.profilePdf', compact('data'));
    $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'], ['isRemoteEnabled' => true])->loadView('apps.mail.profilePdf', compact('data'));
    return $pdf->stream($upload_file.'.pdf');
}    

}
