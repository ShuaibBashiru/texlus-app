<?php

namespace App\Http\Controllers;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Resources\ToJsonResource;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use dateTime;
use PDF;

class SettingController extends Controller
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
        $query = Settings::from('app_settings as t1')
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
        $query = Settings::where('deleted_status', '=', '0')
                                    ->get(['site_name', 'generated_id'])->first();
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
        $query = Settings::where('deleted_status', '=', '0')
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
        $url = $domain.$url;
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
            'company_name' => 'nullable|min:2',
            'site_name' => 'required|min:2',
            'slogan' => 'nullable|min:2',
            'mailing_address' => 'nullable|min:2',
            'email_one' => 'nullable|min:2',
            'email_two' => 'nullable|min:2',
            'phone_one' => 'nullable|min:2',
            'phone_two' => 'nullable|min:2',
            'facebook' => 'nullable|min:2',
            'linkedin' => 'nullable|min:2',
            'youtube' => 'nullable|min:2',
            'twitter' => 'nullable|min:2',
            'office_address' => 'nullable|min:2',
            'state_name' => 'nullable|min:2',
            'country_name' => 'nullable|min:2',
            'copyright' => 'nullable|min:2',
            'descriptions' => 'nullable|min:2',
            'key_words' => 'nullable|min:2',
            'site_status' => 'nullable|min:2',
            'status_description' => 'nullable|min:2',

        ]);
        try {
            $exist = false;
            $failed = false;
            $successful = false;
            $getSession = $request->session()->get('securedata');
            $d = new dateTime();
            $generated_id = str_shuffle($d->format('Ymdhis'));
            $file = $request->file('upload_file')=='' ? '' : $request->file('upload_file');
            $logo_link = $request->input('logo_link');
            $record = [
                "generated_id" => $generated_id,
                "company_name" => $request->input('company_name'),
                "site_name" => $request->input('site_name'),
                "slogan" => $request->input('slogan'),
                "mailing_address" => $request->input('mailing_address'),
                "email_one" => $request->input('email_one'),
                "email_two" => $request->input('email_two'),
                "phone_one" => $request->input('phone_one'),
                "phone_two" => $request->input('phone_two'),
                "facebook" => $request->input('facebook'),
                "linkedin" => $request->input('linkedin'),
                "youtube" => $request->input('youtube'),
                "twitter" => $request->input('twitter'),
                "office_address" => $request->input('office_address'),
                "state_name" => $request->input('state_name'),
                "country_name" => $request->input('country_name'),
                "copyright" => $request->input('copyright'),
                "descriptions" => $request->input('descriptions'),
                "key_words" => $request->input('key_words'),
                "site_status" => $request->input('site_status'),
                "status_description" => $request->input('status_description'),
                "logo_link" => '',
                "created_by" => base64_decode($getSession['userid']),
                "date_created" => $d->format('Y-m-d'),
                "time_created" => $d->format('h:i:s'),
            ];
            $updateRecord = [
                "company_name" => $request->input('company_name'),
                "site_name" => $request->input('site_name'),
                "slogan" => $request->input('slogan'),
                "mailing_address" => $request->input('mailing_address'),
                "email_one" => $request->input('email_one'),
                "email_two" => $request->input('email_two'),
                "phone_one" => $request->input('phone_one'),
                "phone_two" => $request->input('phone_two'),
                "facebook" => $request->input('facebook'),
                "linkedin" => $request->input('linkedin'),
                "youtube" => $request->input('youtube'),
                "twitter" => $request->input('twitter'),
                "office_address" => $request->input('office_address'),
                "state_name" => $request->input('state_name'),
                "country_name" => $request->input('country_name'),
                "copyright" => $request->input('copyright'),
                "descriptions" => $request->input('descriptions'),
                "key_words" => $request->input('key_words'),
                "site_status" => $request->input('site_status'),
                "status_description" => $request->input('status_description'),
                "logo_link" => '',
                "modified_by" => base64_decode($getSession['userid']),
            ];

                $getRecord = $this->ifRecordExist();
                $userid = $getRecord['status'] ? $getRecord['data']['generated_id'] : $generated_id;
                // Check if new image is selected
                if($file != ''){
                    $upload_file = $this->uploadDisplayFile($request, $userid);
                    $record['logo_link'] = $upload_file['logo_link'];
                    $updateRecord['logo_link'] = $upload_file['logo_link'];
                }else if($file == '' && $logo_link!=''){
                    $record['logo_link'] = $logo_link;
                    $updateRecord['logo_link'] = $logo_link;
                }else{
                    $record['logo_link'] = '';
                    $updateRecord['logo_link'] = '';
                }
                if ($getRecord['status']) {
                $query = Settings::where('generated_id', '=', $getRecord['data']['generated_id'])
                                    ->update($updateRecord);
                }else{
                $query = Settings::insert($record);
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
                    "msg" => "Site information has been successfully updated, now redirecting...",
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
