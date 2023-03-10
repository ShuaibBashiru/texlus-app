<?php

namespace App\Http\Controllers;
use App\Models\Statuses;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class StatusesApiController extends Controller
{

    public function listAll()
    {
        try {
        $returnData = '';
        $result = [];
        $query = Statuses::from('statuses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.status_id', '=', 1)
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t1.*']);
       
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

}
