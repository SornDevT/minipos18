<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\StoreController;


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

// Route::get('logout',[UserController::class,'logout']);

Route::group(["middleware"=>["auth:api"]],
    function(){
        Route::get('logout',[UserController::class,'logout']);
    });


Route::group(["middleware"=>["auth:api"]],
    function(){
        Route::get('store',[StoreController::class,'index']);
        Route::post('store/add',[StoreController::class,'add']);
    });