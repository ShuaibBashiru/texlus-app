<?php

namespace App\Http\Controllers;
use App\Models\PointOfSales;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class PosController extends Controller
{
    
    public function list(){
        return view('apps.pos.record');
    }

    public function portal(){
        return view('apps.pos.portal');
    }


    public function getSummary($id){
        $query = PointOfSales::from('vw_sales_record')->where('invoice_number', '=', $id)
                                    ->get()->first();
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

    public function get_invoice(Request $request)
    {
        try {
        $returnData = '';
        $result = [];
        $id = $request->input('invoice_number');
        $summary = $this->getSummary($id);
        $query = PointOfSales::from('sales_records as t1')
                    ->where('t1.invoice_number', '=', $id)
                    ->leftJoin('sales_items as t2', 't2.id', '=', 't1.item_id')
                    ->get(['t1.*', 't2.item_name']);

        if (count($query)>0) {
            $returnData = [
                "title" => "Successful",
                "status" => "success",
                "statusmsg" => "success",
                "msg" => "",
                "redirect" => "",
                "info" => $query,
                "summary" => $summary['data'],
            ];

        }else{
            $returnData = [
                "title" => "Invalid",
                "status" => "norecord",
                "statusmsg" => "",
                "msg" => "No record(s) found.",
                "info" =>"",
                "summary" => "",
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


    public function allSales(){
        $query = PointOfSales::from('sales_records as t1')
                    ->leftJoin('sales_items as t2', 't2.id', '=', 't1.item_id')
                    ->get(['t1.*', 't2.item_name']);
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

    public function listAll()
    {
        try {
        $sales = $this->allSales();
        $returnData = '';
        $result = [];
        $query = PointOfSales::from('vw_sales_record')
                                ->orderBy('date_created', 'ASC')
                                ->get();
       
        if (count($query) > 0) {
             // 
            $returnData = [
                "title" => "Successful",
                "status" => "success",
                "statusmsg" => "success",
                "msg" => "",
                "redirect" => "",
                "info" => $query,
                "sales" => $sales['data'],

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

        public function create(Request $request){
            try {
                $records = 0;
                $exist = 0;
                $noRecord = 0;
                $failed = 0;
                $successful = 0;
                $updatedRecord = 0;
                $count = 0;
                $qtys = explode(',', $request->input('qty'));
                $item_ids = explode(',', $request->input('item_id'));
                $unit_prices = explode(',', $request->input('unit_price'));
                $getSession = $request->session()->get('securedata');
                $d = new dateTime();
                $record = [
                    "qty" => '',
                    "item_id" => '',
                    "unit_price" => '',
                    "amount" => '',
                    "invoice_number" => $request->input('invoice_number'),
                    "payment_type" => $request->input('payment_type'),
                    "customer_id" => $request->input('customer_id'),
                    "soldTo" => $request->input('soldTo'),
                    "amount" => $request->input('amountPaid'),
                    "created_by" => base64_decode($getSession['userid']),
                    "generated_id" => '',
                    "date_created" => $d->format('Y-m-d'),
                    "time_created" => $d->format('h:i:s'),
                    "updated_at" => $d->format("Y-m-d h:i:s"),
                ];
            foreach ($item_ids as $item_id) {
                $record['item_id'] = $item_ids[$count];
                $record['qty'] = $qtys[$count];
                $record['unit_price'] = $unit_prices[$count];
                $record['amount'] = $unit_prices[$count] * $qtys[$count];
                $record['generated_id'] = str_shuffle($d->format('Ymdhis'));
                $query = PointOfSales::insert($record);
                if ($query) {
                    $successful += 1;
                }else{
                    $successful -= 1;
                }
                $count ++;
                }
                // End loop
                if ($successful == $count) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "Sales successfully processed.",
                        "redirect" => "",
                        "successful" => $successful,
                        "failed" => $failed,
                        "exist" => $exist,
                    ];
                } else if($successful > 0) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "Some Sales could not be completed, please comfirm this before you continue.",
                        "redirect" => "",
                        "successful" => $successful,
                        "failed" => $failed,
                        "exist" => $exist,
                    ];
                }else{
                    $returnData = [
                        "title" => "Invalid",
                        "status" => "failed",
                        "statusmsg" => "",
                        "msg" => "Error processing this sale, kindly try again or refresh the page.",
                        "successful" => $successful,
                        "failed" => $failed,
                        "exist" => $exist,
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
    $update = PointOfSales::where('generated_id', '=', $newid)
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
        $update = PointOfSales::where('generated_id', '=', $id)
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
$query = PointOfSales::where('generated_id', '=', $id)
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
        $update = PointOfSales::where('generated_id', '=', $id)
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
