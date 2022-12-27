<?php

namespace App\Http\Controllers;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class CourseController extends Controller
{
    
    public function manage($id){
        $cookie_name = "manageUser";
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.courses.manage', compact('record'));
        }else{
            $message = json_encode("No record found");
            return redirect()->route('list_course')->with('message', json_encode($message));
        }
    }
    public function edit($id){
        $cookie_name = "manageUser";
        $cookie_value = $id;
        $id = base64_decode(base64_decode($id));
        setcookie($cookie_name, $cookie_value, time() + (86400), "/");
        $record = $this->record($id);
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.courses.edit', compact('record'));
        }else{
            $message = json_encode("No record found");
            return redirect()->route('list_course')->with('message', json_encode($message));
        }
    }
    public function list(){
        return view('apps.courses.record');
    }

    public function uploadBatch(){
        return view('apps.courses.upload_record');
    }

    public function createRecord(){
        return view('apps.courses.new_record');
    }
   
    public function record($id)
    {
        try {
        $returnData = '';
        $result = [];
        $query = Courses::from('vw_courses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->where('t1.generated_id', $id)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->get(['t1.*'])->first();

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
        $query = Courses::from('vw_courses as t1')
                    ->where('t1.deleted_status', '=', 0)
                    ->leftJoin('statuses as t2', 't2.id', '=', 't1.status_id')
                    ->orderBy('t1.updated_at', 'DESC')
                    ->get(['t1.*']);
       
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

    public function fileExist($id){
        $query = Courses::where('deleted_status', '=', '0')
                                    ->where('generated_id', '=', $id)
                                    ->get(['display_media'])->first();
        if($query){
            $data=[
                'status' => true,
                'data' => $query,
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

    public function uploadDisplayFile(Request $request, $id){
        $request->validate([
            'upload_file' => 'required|mimes:jpeg,png,gif,webp,mp4,mkv',
        ]);
        
        $exist = false;
        $failed = false;
        $successful = false;
        $fileexist = $this->fileExist($id);
        $d = new dateTime();
        $generated_id = str_shuffle($d->format('Ymdhis'));
        $file = $request->file('upload_file');
        $upload_file = $file->hashName();
        $extension = $file->extension();
        $dir = 'public/media/'.$request->input('media_type');
        $path = Storage::putFileAs($dir, new File($file), $upload_file);
        $filepath = $dir.'/'.$upload_file;
        $url = Storage::url($filepath);
        $domain = request()->getSchemeAndHttpHost();
        $url = $url;
        if (!$fileexist['status']) {
            $data=[
                'status' => true,
                'media_link' => $url,
            ];
            return $data;
        }else{
            $filename = explode('/', $fileexist['data']['display_media']);
            Storage::delete($dir.'/'.end($filename));
            $data=[
                'status' => true,
                'media_link' => $url,
            ];
            return $data;
        }
        $dataToJson = new ToJsonResource($returnData);
        return $dataToJson;
    
        }
   

    public function create(Request $request){
       $request->validate([
            'post_title' => 'required|unique:courses_tbl|min:2',
            'post_summary' => 'nullable|min:2',
            'post_body' => 'nullable|min:2',
            'post_link' => 'required|min:2',
            'display_media_status' => 'required|max:10|min:1',
            'read_more_status' => 'required|max:10|min:1',
            'read_more_title' => 'required|max:100|min:2',
            'read_more_type' => 'required|max:80|min:2',
            'media_height' => 'required|max:50|min:2',
            'media_width' => 'required|max:50|min:2',
            'media_type' => 'required|max:50|min:2',
            'media_measure' => 'required|max:50|min:1',
            'original_price' => 'required|max:50|min:1',
            'discount' => 'required|max:50|min:1',
            'discounted_price' => 'required|max:50|min:1',
            'durations' => 'required|max:50|min:1',
            'class_mode' => 'required|max:50|min:1',
            'startDate' => 'required|max:50|min:1',
            'display_media' => 'nullable|max:10|min:1',
            'category_id' => 'required|max:50|min:1',
            'status_id' => 'required|max:50|min:1',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $file = $request->file('upload_file')=='' ? '' : $request->file('upload_file');
            $record = [
                "generated_id" => $generated_id,
                "post_title" => $request->input('post_title'),
                "post_summary" => $request->input('post_summary'),
                "post_body" => $request->input('post_body'),
                "post_link" => $request->input('post_link'),
                "display_media_status" => $request->input('display_media_status'),
                "read_more_status" => $request->input('read_more_status'),
                "read_more_title" => $request->input('read_more_title'),
                "read_more_type" => $request->input('read_more_type'),
                "media_height" => $request->input('media_height'),
                "media_width" => $request->input('media_width'),
                "media_measure" => $request->input('media_measure'),
                "original_price" => $request->input('original_price'),
                "discount" => $request->input('discount'),
                "discounted_price" => $request->input('discounted_price'),
                "durations" => $request->input('durations'),
                "class_mode" => $request->input('class_mode'),
                "startDate" => $request->input('startDate'),
                "media_type" => $request->input('media_type'),
                "display_media" => '',
                "category_id" => $request->input('category_id'),
                "status_id" => $request->input('status_id'),
                "created_by" => base64_decode($getSession['userid']),
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                // Check if new image is selected
                if($file == ''){
                    $record['display_media'] = '';
                }else if($file != ''){
                    $upload_file = $this->uploadDisplayFile($request, $generated_id);
                    $record['display_media'] = $upload_file['media_link'];
                }else{
                    $record['display_media'] = '';
                }
                $query = Courses::insert($record);
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
                    "msg" => "New post has been successfully created, now redirecting...",
                    "redirect" => "list",
                ];
            }else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This post could not be created right now! Please refresh and try again or report this error for further assistance.",
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
            'generated_id' => 'required',
            'post_title' => 'required|min:2',
            'post_summary' => 'nullable|min:2',
            'post_body' => 'nullable|min:2',
            'post_link' => 'required|min:2',
            'display_media_status' => 'required|max:10|min:1',
            'read_more_status' => 'required|max:10|min:1',
            'read_more_title' => 'required|max:100|min:2',
            'read_more_type' => 'required|max:80|min:2',
            'media_height' => 'required|max:50|min:2',
            'media_width' => 'required|max:50|min:2',
            'media_measure' => 'required|max:50|min:1',
            'original_price' => 'required|max:50|min:1',
            'discount' => 'required|max:50|min:1',
            'discounted_price' => 'required|max:50|min:1',
            'durations' => 'required|max:50|min:1',
            'class_mode' => 'required|max:50|min:1',
            'startDate' => 'required|max:50|min:1',
            'display_media' => 'nullable|max:10|min:1',
            'category_id' => 'required|max:50|min:1',
            'status_id' => 'required|max:50|min:1',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $id = base64_decode(base64_decode($request->input('generated_id')));
            $file = $request->file('upload_file')=='' ? '' : $request->file('upload_file');
            $media_link = $request->input('media_link')=='' ? '' : $request->input('media_link');
            $record = [
                "post_title" => $request->input('post_title'),
                "post_summary" => $request->input('post_summary'),
                "post_body" => $request->input('post_body'),
                "post_link" => $request->input('post_link'),
                "display_media_status" => $request->input('display_media_status'),
                "read_more_status" => $request->input('read_more_status'),
                "read_more_title" => $request->input('read_more_title'),
                "read_more_type" => $request->input('read_more_type'),
                "media_height" => $request->input('media_height'),
                "media_width" => $request->input('media_width'),
                "media_measure" => $request->input('media_measure'),
                "media_measure" => $request->input('media_measure'),
                "original_price" => $request->input('original_price'),
                "discount" => $request->input('discount'),
                "discounted_price" => $request->input('discounted_price'),
                "durations" => $request->input('durations'),
                "class_mode" => $request->input('class_mode'),
                "startDate" => $request->input('startDate'),
                "media_type" => $request->input('media_type'),
                "display_media" => '',
                "category_id" => $request->input('category_id'),
                "status_id" => $request->input('status_id'),
                "modified_by" => base64_decode($getSession['userid']),
                "updated_at" => $d->format("Y-m-d h:i:s"),
            ];
                if($file == '' && $media_link==''){
                    $record['display_media'] = '';
                }else if($file != ''){
                    $upload_file = $this->uploadDisplayFile($request, $id);
                    $record['display_media'] = $upload_file['media_link'];
                }else if($media_link !='' && $file==''){
                    $record['display_media'] = $media_link;
                }else{
                    $record['display_media'] = '';
                }
                $query = Courses::where('generated_id', '=', $id)
                                ->update($record);
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
                    "msg" => "Post has been successfully updated, now redirecting...",
                    "redirect" => "",
                ];
            }else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "This post could not be updated right now! Please refresh and try again or report this error for further assistance.",
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
    $update = Courses::where('generated_id', '=', $newid)
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
        $update = Courses::where('generated_id', '=', $id)
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
$query = Courses::where('generated_id', '=', $id)
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
            "post_title" => $request->input('post_title').'::deleted',
        ];
        
    if ($this->checkBeforeDelete($id, 0)) {
        $update = Courses::where('generated_id', '=', $id)
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
