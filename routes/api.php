<?php

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
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
Route::namespace('Api')->group( function(){  

	
	
	
	
});
Route::resource('user-data', 'Api\UserController');
Route::resource('register', 'Api\RegisterController');
Route::resource('login', 'Api\LoginController');
Route::resource('all-property', 'Api\PropertyController');
Route::resource('my-family', 'Api\MyfamilyController');
Route::post('my-family/get', 'Api\MyfamilyController@getAllFamily');
Route::resource('otp-genrate', 'Api\OtpController');
Route::resource('otp-verify', 'Api\OtpVerifyController');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
