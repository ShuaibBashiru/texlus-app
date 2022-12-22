<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use dateTime;

class CountryController extends Controller
{
    
    public function manage($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
         // 
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.country.manage', compact('record'));
        }else{
            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_country')->with('message', json_encode($message));
        }
    }else{
        $message = [
                "type" => "info",
                "info" => "",
             ];
        return redirect()->route('list_country')->with('message', json_encode($message));
    }
    }

    public function edit_name($id){
        if (isset($_COOKIE['manageUser']) && ($id === $_COOKIE['manageUser'])) {
             // 
            $record = $this->record($id);
            if ($record['status']=='success') {
                $record = $record['info'];
                return view('apps.country.edit_name', compact('record'));
            }else{
                $message = [
                "type" => "info",
                "info" => "",
             ];
                return redirect()->route('list_country')->with('message', json_encode($message));
            }
        }else{
            $message = [
                "type" => "info",
                "info" => "",
             ];
            return redirect()->route('list_country')->with('message', json_encode($message));
        }
    }

    public function list(){
        return view('apps.country.records');
    }

    public function uploadBatch(){
        return view('apps.country.upload_records');
    }

    public function list_items()
    {
        try {
        $returnData = '';
        $result = [];
        $query = Country::where('deleted_status', '=', '0')
                    ->get(['country_name', 'id']);
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
