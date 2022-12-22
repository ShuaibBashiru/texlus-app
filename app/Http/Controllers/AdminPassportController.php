<?php

namespace App\Http\Controllers;
use App\Models\AdminPassport;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;

class AdminPassportController extends Controller
{
    
    public function getData($userid){
        $query = Admin::where('deleted_status', '=', '0')
                                    ->where('personal_id', '=', $userid)
                                    ->get(['id'])->first();
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
    public function fileExist($userid){
        $query = AdminPassport::where('deleted_status', '=', '0')
                                    ->where('userid', '=', $userid)
                                    ->get(['id', 'file_name'])->first();
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
        public function passport(Request $request){
            $request->validate([
                'personal_id' => 'required|string|max:30|min:6',
                'upload_file' => 'required|max:2000|mimes:jpg',
            ]);
            try {
                $exist = false;
                $failed = false;
                $successful = false;
                $getSession = $request->session()->get('securedata');
                $d = new dateTime();
                $generated_id = str_shuffle($d->format('Ymdhis'));
                $userid  = strtolower($request->input('personal_id'));
                $file = $request->file('upload_file');
                $upload_file = $file->hashName();
                $extension = $file->extension();
                $dir = 'public/passports/admin';
                $path = Storage::putFileAs($dir, new File($file), $upload_file);
                $filepath = $dir.'/'.$upload_file;
                $url = Storage::url($filepath);
        $domain = request()->getSchemeAndHttpHost();
        $url = $domain.$url;
                $size = Storage::size($filepath);
                $dimensions = getimagesize($file);
                $userData = $this->getData($userid);
                $record = [
                    "userid" => $userData['data']['id'],
                    "generated_id" => $generated_id,
                    "file_name" => $upload_file,
                    "file_size" => $size,
                    "file_width" => $dimensions[0]? $dimensions[0] : '0',
                    "file_height" => $dimensions[1]? $dimensions[1] : '0',
                    "file_ext" => $extension,
                    "file_url" => $url,
                    "file_title" => '',
                    "created_by" => base64_decode($getSession['userid']),
                    "date_created" => $d->format('Y-m-d'),
                    "time_created" => $d->format('h:i:s'),
                    "updated_at" => $d->format("Y-m-d h:i:s"),
                ];
                $recordUpdate = [
                    "file_name" => $upload_file,
                    "file_size" => $size,
                    "file_width" => $dimensions[0]? $dimensions[0] : '0',
                    "file_height" => $dimensions[1]? $dimensions[1] : '0',
                    "file_ext" => $extension,
                    "file_url" => $url,
                    "file_title" => '',
                    "modified_by" => base64_decode($getSession['userid']),
                    "updated_at" => $d->format("Y-m-d h:i:s"),
                ];
                    $fileexist = $this->fileExist($record['userid']);
                    if (!$fileexist['status']) {
                        $query = AdminPassport::insert($record);
                        if ($query) {
                        $successful = true;
                        }else{
                        $failed = true;
                        }
                    }else{
                        Storage::delete($dir.'/'.$fileexist['data']['file_name']);
                        $query = AdminPassport::where('userid', '=', $record['userid'])
                                            ->update($recordUpdate);
                        if ($query) {
                        $successful = true;
                        }else{
                        $failed = true;
                        }
                    }
        
                if ($successful) {
                    $returnData = [
                        "title" => "Successful",
                        "status" => "success",
                        "statusmsg" => "success",
                        "msg" => "Successfully updated. Reloading the changes...",
                        "redirect" => "",
                    ];
                }else{
                    $returnData = [
                        "title" => "Invalid",
                        "status" => "failed",
                        "statusmsg" => "",
                        "msg" => "Error updating this record! Please refresh and try again.",
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
