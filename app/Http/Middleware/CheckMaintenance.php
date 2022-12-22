<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function fileInfo(){
        $filepath = Storage::path('public/settings/app.json');
        $json = json_decode(file_get_contents($filepath), true);
        $settings = $json;
        return $settings;
    }
    
    public function handle(Request $request, Closure $next)
    {
        $check = $this->fileInfo();
        if($check['site_status']=='Active') {
            return $next($request);
         }else{
            return redirect('/app/maintenance');
         }

    }
}
