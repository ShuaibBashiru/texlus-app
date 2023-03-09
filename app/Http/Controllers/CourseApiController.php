<?php

namespace App\Http\Controllers;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class CourseApiController extends Controller
{

    public function showAll()
    {
        try {
        $returnData = '';
        $result = [];
        $query = Courses::from('vw_courses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.status_name', '=', 'Active')
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->get(['t1.*']);

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

   
    public function showByTitle($category, $title)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Courses::from('vw_courses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.status_name', '=', 'Active')
                    ->where('t1.category_name', $category)
                    ->where('t1.item_title', $title)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->get(['t1.*'])->first();

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

    public function showAllInCategory($category)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Courses::from('vw_courses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.status_name', '=', 'Active')
                    ->where('t1.category_name', $category)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
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
