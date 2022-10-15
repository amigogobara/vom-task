<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\Merchant\AuthenticationController;

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

Route::group(['prefix' => 'merchant'], function() {
    Route::post('/register', [AuthenticationController::class, 'register']);

    Route::post('/login', [AuthenticationController::class, 'login']);

    Route::post('/logout', [AuthenticationController::class,'logout']);

    Route::group(['middleware' => 'auth:api'],function (){

        Route::get('store', [
            \App\Http\Controllers\Api\Merchant\StoreSettingsController::class,'index'
        ]);

        Route::post('update-store-settings', [
            \App\Http\Controllers\Api\Merchant\StoreSettingsController::class,'update'
        ]);

        Route::apiResource('/products',\App\Http\Controllers\Api\Merchant\ProductController::class);
    });
});

Route::group(['prefix' => 'customer'] , function() {
    Route::get('products',[
        \App\Http\Controllers\Api\Customer\ProductController::class,'index'
    ]);
});
