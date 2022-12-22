<?php

namespace App\Http\Controllers;
use App\Models\AdminMenu;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class MenuApiController extends Controller
{
   

    public function menuList(Request $request)
    {
        try {
        $returnData = '';
        $result = [];
        $query = AdminMenu::from('admin_app_menu as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t2.status_name', '=', 'Active')
                    ->where('t3.menu_bar', 'Web Menu')
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->leftJoin('admin_app_menu_group as t3', 't3.id', '=', 't1.group_id')
                    ->leftJoin('access_permissions as t4', 't4.id', '=', 't1.access_permission_id')
                    ->orderBy('t1.id', 'ASC')
                    ->get(['t4.title as menu_title', 't1.group_id', 't1.access_permission_id', 't1.link_target', 't3.group_name', 't4.routeLink', 't3.group_icon', 't4.descriptions', 
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



}
