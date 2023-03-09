<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\CourseApiController;
use App\Http\Controllers\MenuApiController;
use App\Http\Controllers\NotificationApiController;
use App\Http\Controllers\StatusesApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/post/info/{category}', [PostApiController::class, 'showAllInCategory']);
Route::get('/post/info/{category}/{title}', [PostApiController::class, 'showByTitle']);
Route::get('/course/info', [CourseApiController::class, 'showAll']);
Route::get('/course/info/{category}', [CourseApiController::class, 'showAllInCategory']);
Route::get('/course/info/{category}/{title}', [CourseApiController::class, 'showByTitle']);
Route::get('/menu', [MenuApiController::class, 'menuList']);
Route::get('/notification/list', [NotificationApiController::class, 'notifications']);
Route::get('/status/list', [StatusesApiController::class, 'listAll']);
