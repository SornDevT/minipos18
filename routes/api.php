<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\TransectionController;



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
        Route::get('store/edit/{id}',[StoreController::class,'edit']);
        Route::post('store/add',[StoreController::class,'add']);
        Route::post('store/update/{id}',[StoreController::class,'update']);
        Route::delete('store/delete/{id}',[StoreController::class,'delete']);
    });

    Route::group(["middleware"=>["auth:api"]],
    function(){
        // Route::get('transection',[TransectionController::class,'index']);
        // Route::get('transection/edit/{id}',[TransectionController::class,'edit']);
        Route::post('transection/add',[TransectionController::class,'add']);
        // Route::post('transection/update/{id}',[TransectionController::class,'update']);
        // Route::delete('transection/delete/{id}',[TransectionController::class,'delete']);
    });