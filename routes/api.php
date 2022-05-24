<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

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

Route::post('/posts/create',[PostController::class,'create']);

Route::prefix('auth')->middleware('api')->group(function(){
    Route::post('/login',[AuthController::class, 'login']);
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::post('/refresh',[AuthController::class, 'refresh']);
    Route::post('/me',[AuthController::class, 'me']);
});

Route::prefix('users')->middleware('auth:api')->group(function(){
    Route::get('/',[UserController::class,'getList'])->middleware('role:Admin');
    Route::post('/create',[UserController::class,'create'])->middleware('role:Admin');
    Route::post('/edit/{id}',[UserController::class,'edit']);
    Route::delete('delete/{id}',[UserController::class,'delete']);


});


