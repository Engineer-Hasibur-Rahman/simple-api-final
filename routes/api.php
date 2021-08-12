<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// public route
Route::post('/login',[AuthController::class, 'Login']);
Route::post('/register',[AuthController::class, 'Register']);
//procted route
Route::group(['middleware' =>['auth:sanctum']],function(){
    Route::resource('/product',ProductController::class);
    Route::post('/logout',[AuthController::class, 'Logout']);
});

