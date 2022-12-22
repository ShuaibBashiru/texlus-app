<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEditToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
    // Here, this method checks for every page that modifify data on single page session and cookie only
    // For update, delete, edit
        if (isset($_COOKIE['manageUser'])) {
            return $next($request);
            echo $_SERVER['HTTP_REFERER'];
        }else{
            setcookie("manageUser", "", time() - 3600, "/");
            $request->session()->forget(['update_data', 'update_id']);
            return redirect()->back();
        }
        
         
    }
}
