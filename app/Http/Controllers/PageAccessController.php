<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageAccessController extends Controller
{
    public function pageNotFound(){
        // echo "You do not have access to use this page";
    }

    public function noAccess(){
        return view('errors.no_access');
    }

    public function getRoutes(){
        $routes = collect(\Route::getRoutes())->map(function ($route) { 
            $record = [];
            $routeLink = [
                "routeLink" => '',
            ];
            $url = explode('{', $route->uri());
            $url2 = explode('{', $route->getName());
            $routeLink['routeLink'] = $url2[0];
            array_push($record, $routeLink);
            return $record;
        });

        // print_r($routes);
        foreach($routes as $key){
            echo $key[0]['routeLink'].'<br/>';
        }

    }
}
