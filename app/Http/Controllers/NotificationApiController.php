<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class NotificationApiController extends Controller
{
    
    public function notifications(Request $request)
    {
        try {
        $returnData = '';
        $result = [];
        $d = new dateTime();
        $today = $d->format('Y-m-d');
        $id = $request->input('email_id');
        $query = Notification::from('notification_tbl as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.expire_date', '>=', $today)
                    ->where(function($query) use($id) {
                        $query->where('t1.recipient', '=', 'All')
                        ->orWhere('t1.recipient', '=', $id);
                    })
                    ->where('t2.status_name', '=', 'Active')
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t1.id', 't1.title', 't1.recipient', 't1.expire_date', 't1.date_created', 't1.descriptions', 't1.date_created',
                    't1.status_id', 't2.status_name', 't1.generated_id', 't1.updated_at']);
       
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
