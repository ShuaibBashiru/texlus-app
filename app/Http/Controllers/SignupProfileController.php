<?php

namespace App\Http\Controllers;
use App\Models\Signup;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;


class SignupProfileController extends Controller
{
    public function signup()
    {
        return view('apps.application.new_record');
    }

    
   
    public function checkIfIdIsValid($data){
        $query = Signup::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $data['personal_id'])
                                    ->get()->first();
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function getData($userid){
        $query = Signup::where('deleted_status', '=', '0')
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
        $query = Signup::from('admin_record as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('genders as t3', 't3.id', '=', 't1.gender_id')
                    ->leftJoin('countries as t4', 't4.id', '=', 't1.country_id')
                    ->leftJoin('states as t5', 't5.id', '=', 't1.state_id')
                    ->leftJoin('admin_passport as t6', 't6.userid', '=', 't1.id')
                    ->get(['t1.personal_id', 'lastname', 'firstname', 'othername', 
                    'email_one', 'email_two', 'phone_one', 'phone_two', 'phone_code', 
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

 
    public function checkIfRecordExist($data){
        $query = Signup::where('deleted_status', '=', '0')
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
   
    public function create(SignUpRequest $request){
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $personal_id = strtoupper($request->input('personal_id'));
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
                "created_by" => 0,
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $query = Signup::insert($record);
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
                    "msg" => " Your account was created successfully. 
                    To continue, kindly click the link that was sent to the email provided to set your password.",
                    "redirect" => "/signin",
                ];
            }else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This account could not be created right now! Please refresh and try again or report this error for further assistance.",
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

public function checkBeforeDelete($id, $status){
$query = Signup::where('generated_id', '=', $id)
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
        $id = $request->input('id');
        $id = base64_decode(base64_decode($id));
        $row = [
            "deleted_by" => base64_decode($getSession['userid']),
            "deleted_status" => 1,
            "personal_id" => 'deleted::'.$request->input('personal_id'),
            "email_one" => 'deleted::'.$request->input('email_one'),
            "phone_one" => 'deleted::'.$request->input('phone_one'),
        ];
        
    if ($this->checkBeforeDelete($id, 0)) {
        $update = Signup::where('generated_id', '=', $id)
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
    $timeseries = str_shuffle($d->format('Ymdhis'));
    $upload_file = $record['info']['lastname'].'_'.$record['info']['firstname']
    .'_'.$record['info']['personal_id'];
    $base = base_path();
    $passport_dir = base_path().'/public/storage/passports/admin';
    $filepath = $passport_dir.'/'.$record['info']['file_name'];
    $extension = pathinfo($filepath, PATHINFO_EXTENSION);
    $image = base64_encode(file_get_contents($filepath));
    $fileInfo=$this->fileInfo();
    $data = [
        "dated" => $d->format('d-m-Y'),
        "title" => "Account Profile",
        "headerName" => $fileInfo['site_name'],
        "owner" => $fileInfo['site_name'],
        "copyright" => $fileInfo['copyright'],
        "user_info" => $record['info'],
        "user_image" => $image,
    ];
    $upload_file = $data['title'].'_'.$record['info']['lastname'].'_'.$record['info']['firstname']
    .'_'.$record['info']['personal_id'];

    // return view('apps.account.userProfilePdf', compact('data'));
    $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'], ['isRemoteEnabled' => true])->loadView('apps.account.profilePdf', compact('data'));
    return $pdf->stream($upload_file.'.pdf');
}    


}
