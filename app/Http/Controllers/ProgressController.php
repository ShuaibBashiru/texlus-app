<?php

namespace App\Http\Controllers;
use App\Models\Progress;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class ProgressController extends Controller
{
    public function fileInfo(){
        $filepath = Storage::path('public/settings/app.json');
        $json = json_decode(file_get_contents($filepath), true);
        $settings = $json;
        return $settings;
    }

    public function maintenance(){
        $check = $this->fileInfo();
        if ($check['site_status']=='Active') {
           return redirect()->route("home");
        }else{
            $message = json_encode($check['status_description']);
            return view('apps.settings.maintenance', compact('message'));
        }
    }

    public function manage(){
        $record = $this->record();
        if ($record['status']=='success') {
            $record = $record['info'];
            return view('apps.settings.manage', compact('record'));
        }else{
            $record = [];
            return view('apps.settings.manage');
        }
    }

  public function saveToJson(){
    $getRecord = $this->record();
    if ($getRecord['status']=='success') {
        Storage::disk('public')->put('settings/app.json', json_encode($getRecord['info']));
    }
  }
    public function record(){

        try {
        $returnData = '';
        $result = [];
        $query = Progress::from('app_settings as t1')
                    ->where('t1.deleted_status', '=', 0)
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

    public function ifRecordExist(){
        $query = Progress::where('deleted_status', '=', '0')
                                    ->where('userid', 4)
                                    ->where('enrolled_id', 1)
                                    ->get(['userid', 'generated_id'])->first();
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

    public function fileExist($id){
        $query = Progress::where('deleted_status', '=', '0')
                                    ->where('generated_id', '=', $id)
                                    ->get(['logo_link'])->first();
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
            'upload_file' => 'required|max:400|mimes:jpeg,png,jpg',
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
                'logo_link' => $url,
            ];
            return $data;
        }else{
            $filename = explode('/', $fileexist['data']['logo_link']);
            Storage::delete($dir.'/'.end($filename));
            $data=[
                'status' => true,
                'logo_link' => $url,
            ];
            return $data;
        }
        $dataToJson = new ToJsonResource($returnData);
        return $dataToJson;
    
        }
   

    public function create(Request $request){
       
       $request->validate([
            'assignment' => 'required|min:1',
            'project' => 'required|min:1',
            'consistency' => 'required|min:1',
            'remark' => 'required|min:1',
            'userid' => 'required|min:1',
            'enrolled_id' => 'required|min:1',
        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $record = [
                "generated_id" => $generated_id,
                "assignment" => $request->input('assignment'),
                "project" => $request->input('project'),
                "consistency" => $request->input('consistency'),
                "userid" => $request->input('userid'),
                "enrolled_id" => $request->input('enrolled_id'),
                "remark" => $request->input('remark'),
                "created_by" => base64_decode($getSession['userid']),
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
            ];

            $updateRecord = [
                "generated_id" => $generated_id,
                "assignment" => $request->input('assignment'),
                "project" => $request->input('project'),
                "consistency" => $request->input('consistency'),
                "remark" => $request->input('remark'),
                "modified_by" => base64_decode($getSession['userid']),
            ];

                $getRecord = $this->ifRecordExist();
                $userid = $getRecord['status'] ? $getRecord['data']['generated_id'] : $generated_id;
                if ($getRecord['status']) {
                $query = Progress::where('generated_id', '=', $userid)
                                    ->update($updateRecord);
                }else{
                    $query = Progress::insert($record);
                }
                if ($query) {
                    $this->saveToJson();
                    $successful = true;
                }else{
                    $failed = true;
                }
    
            if ($successful) {
                $returnData = [
                    "title" => "Successful",
                    "status" => "success",
                    "statusmsg" => "success",
                    "msg" => "Progress has been successfully updated, now redirecting...",
                    "redirect" => "list",
                ];
            }else{
                $returnData = [
                    "title" => "Invalid",
                    "status" => "failed",
                    "statusmsg" => "",
                    "msg" => "Something went wrong! Please refresh and try again or report this error for further assistance.",
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



}
