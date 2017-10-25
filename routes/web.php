<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('logout', 'Auth\LoginController@logout');
Route::get('all-user', 'AdminController@getAllUsers');
Route::get('property', 'AdminController@getAllProperty');
Route::get('add-property', 'AdminController@addNewProperty');
Route::post('admin/update-property', 'AdminController@updateProperty');
Route::get('deleteproperty/{id}', 'AdminController@deleteProperty');
Route::post('admin/add-property', 'AdminController@sendProperty');
Route::get('image-upload-with-validation',['as'=>'getimage','uses'=>'ImageController@getImage']);
Route::post('image-upload-with-validation',['as'=>'postimage','uses'=>'ImageController@postImage']);

Auth::routes();

Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');

