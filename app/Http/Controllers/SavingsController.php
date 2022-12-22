<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\Savings;
use App\Http\Requests\PassportRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use PDF;
use dateTime;

class SavingsController extends Controller
{
    public function fileInfo(){
        $data = [
            'owner' => "Yabatech Prestige Multipurpose Cooperative Society",
            'headerName' => "Yabatech Prestige Multipurpose Cooperative Society",
        ];
        return $data;
    }

    public function record($id)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Users::from('users_record as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('genders as t3', 't3.id', '=', 't1.gender_id')
                    ->leftJoin('countries as t4', 't4.id', '=', 't1.country_id')
                    ->leftJoin('states as t5', 't5.id', '=', 't1.state_id')
                    ->leftJoin('passports as t6', 't6.userid', '=', 't1.id')
                    ->get(['t1.personal_id', 'lastname', 'firstname', 'othername', 
                    'email_one', 'email_two', 'phone_one', 'phone_two', 'phone_code', 
                    'date_of_birth', 't1.country_id', 't1.state_id', 't4.country_name', 't5.state_name', 
                    'address_one', 'dob', 'mob', 'yob', 'gender_name', 'gender_id', 't2.status_name', 
                    'address_one', 't6.file_url', 't6.file_name', 't1.generated_id', 't1.updated_at'])->first();

        if ($query) {
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
                "info" => "",
                "msg" => "No record(s) found.",
            ];

        }
        $dataToJson = new ToJsonResource($returnData);
        return $dataToJson;
        } catch (Exception $e) {
            $returnData = [
                "title" => "Invalid",
                "status" => "server error",
                "statusmsg" => "",
                "info" => "",
                "msg" => "Something went wrong! Please check your network connection and try again or report this error for further assistance.",
                "error" => $e->message()
            ];
            $dataToJson = new ToJsonResource($returnData);
            return $dataToJson;
        }
    }
    public function savings($id)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Savings::where('deleted_status', '=', '0')
                    ->where('userid', $id)
                    ->get(['personal_id', 'updated_at'])->first();

        if ($query) {
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
                "info" => "",

            ];

        }
        $dataToJson = new ToJsonResource($returnData);
        return $dataToJson;
        } catch (Exception $e) {
            $returnData = [
                "title" => "Invalid",
                "status" => "server error",
                "statusmsg" => "",
                "info" => "",
                "msg" => "Something went wrong! Please check your network connection and try again or report this error for further assistance.",
                "error" => $e->message()
            ];
            $dataToJson = new ToJsonResource($returnData);
            return $dataToJson;
        }
    }
   
    public function savingsPdf($id){
        if (!isset($_COOKIE['manageUser']) || ($id != $_COOKIE['manageUser'])) {
            return redirect()->route('dashboard');
        }else{
         // 
        $record = $this->record($id);
        $savings = $this->savings($record['info']['user_id']);
        $d = new dateTime();
        $timeseries = str_shuffle($d->format('Ymdhis'));
        $upload_file = $record['info']['lastname'].'_'.$record['info']['firstname']
        .'_'.$record['info']['personal_id'];
        $fileInfo=$this->fileInfo();
        $data = [
            "dated" => $d->format('d-m-Y'),
            "title" => "Savings",
            "headerName" => $fileInfo['site_name'],
            "owner" => $fileInfo['owner'],
            "user_info" => $record['info'],
            "savings" => $savings['info'],
        ];
        $upload_file = $data['title'].'_'.$record['info']['lastname'].'_'.$record['info']['firstname']
        .'_'.$record['info']['personal_id'];

        return view('apps.savings.SavingsPdf', compact('data'));
        $pdf = PDF::setOptions(['defaultFont' => 'sans-serif'], ['isRemoteEnabled' => true])->loadView('apps.savings.SavingsPdf', compact('data'));
        return $pdf->stream($upload_file.'.pdf');
    }    
    } 

}
