<?php

namespace App\Http\Controllers;
use App\Models\SalesItems;
use Illuminate\Http\Request;
use App\Http\Requests\SalesItemsRequestBatch;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class SalesItemsController extends Controller
{
    
    public function manage($id){
        $cookie_name = "manageUser";
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.sales_items.manage', compact('record'));
        }else{
            $message = json_encode("No record found");
            return redirect()->route('list_salesitems')->with('message', json_encode($message));
        }
    }

    public function list(){
        return view('apps.sales_items.record');
    }

    public function uploadBatch(){
        return view('apps.sales_items.upload_record');
    }

    public function createRecord(){
        return view('apps.sales_items.new_record');
    }

    public function checkIfIdIsValid($data){
        $query = SalesItems::where('deleted_status', '=', '0')
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

        $query = SalesItems::from('sales_items as t1')
            ->where('t1.deleted_status', '=', 0)
            ->where('t1.generated_id', $id)
            ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
            ->orderBy('t1.updated_at', 'DESC')
            ->get(['t1.item_name', 't1.unit_price', 't1.date_created',
            't1.status_id', 't1.id', 't2.status_name', 't1.generated_id', 't1.updated_at'])->first();

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
        $query = SalesItems::from('sales_items as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t1.item_name', 't1.unit_price', 't1.date_created',
                    't1.status_id', 't1.id', 't2.status_name', 't1.generated_id', 't1.updated_at']);
       
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
        $query = SalesItems::from('sales_items')->where('deleted_status', '=', '0')
                                    ->where('item_name', '=', $data['item_name'])
                                    ->get()->first();
        if($query){
            return true;                
        }else{
            return false;
        }
    }

        public function upload(SalesItemsRequestBatch $request){
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
                    "item_name" => '',
                    "unit_price" => '',
                    "created_by" => base64_decode($getSession['userid']),
                    "generated_id" => '',
                    "date_created" => $d->format('Y-m-d'),
                    "time_created" => $d->format('h:i:s'),
                    "updated_at" => $d->format("Y-m-d h:i:s"),
                ];
            foreach ($data as $row) {
                $record['generated_id'] = str_shuffle($d->format('Ymdhis'));
                $record['item_name'] = ucfirst(strtolower($row['item']));
                $record['unit_price'] = $row['price'];
                $status = [
                    "upload_status" => ""
                ];
                array_merge($row, $status);
                array_push($records, $row);
                if($this->checkIfRecordExist($record)){
                    $row['upload_status'] = 'Exist';
                    array_push($exist, $row);
                }else{
                    $query = SalesItems::from('sales_items')->insert($record);
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

            public function create(Request $request){
                $request->validate([
                    'item_name' => 'required|max:255|min:2',
                    'unit_price' => 'required|max:255|min:2',
                ]);
                try {
                    $exist = false;
                    $failed = false;
                    $successful = false;
                    $getSession = $request->session()->get('securedata');
                    $id = base64_decode(base64_decode($request->input('generated_id')));
                    $d = new dateTime();
                    $record = [
                        "item_name" => ucfirst(strtolower($request->input('item_name'))),
                        "unit_price" => $request->input('unit_price'),
                        "created_by" => base64_decode($getSession['userid']),
                        "generated_id" => str_shuffle($d->format('Ymdhis')),
                        "date_created" => $d->format('Y-m-d'),
                        "time_created" => $d->format('h:i:s'),
                        "updated_at" => $d->format("Y-m-d h:i:s"),
                    ];

                    if($this->checkIfRecordExist($record)){
                            $exist = true;
                    }else{
                        $query = SalesItems::insert($record);
                        if ($query) {
                            $successful = true;
                        }else{
                            $failed = true;
                        }
                        }
            
                    if($successful) {
                        $returnData = [
                            "title" => "Successful",
                            "status" => "success",
                            "statusmsg" => "success",
                            "msg" => "The record was successfully created, please wait a moment while reloading the changes you made.",
                            "redirect" => "",
                        ];
                    }else if($exist) {
                        $returnData = [
                            "title" => "Invalid",
                            "status" => "failed",
                            "statusmsg" => "success",
                            "msg" => "The record already exist, please confirm and try again.",
                            "redirect" => "",
                        ];
                    }  else{
                        $returnData = [
                            "title" => "Invalid",
                            "status" => "failed",
                            "statusmsg" => "",
                            "msg" => "This record could not be created! Please refresh and try again.",
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
            'item_name' => 'required|max:255|min:2',
            'unit_price' => 'required|max:255|min:2',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $d = new dateTime();
            $record = [
                "unit_price" => $request->input('unit_price'),
                "created_by" => base64_decode($getSession['userid']),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                $update = SalesItems::
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
    $update = SalesItems::where('generated_id', '=', $newid)
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
        $update = SalesItems::where('generated_id', '=', $id)
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
$query = SalesItems::where('generated_id', '=', $id)
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
            "routeLink" => 'deleted::'.$request->input('routeLink'),
        ];
        
    if ($this->checkBeforeDelete($id, 0)) {
        $update = SalesItems::where('generated_id', '=', $id)
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
