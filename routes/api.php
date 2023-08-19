<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\LoginController;

//Route::post('/auth/login',LoginController::class,'login');


Route::group(['prefix'=>'admin'],function (){
  Route::resources([
      '/user'=> UserController::class,
      '/post'=> PostController::class,
  ]);
});


/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
