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
    return view('auth.login');
});
/*Route::get('/example', function()
{
  // Run controller and method
  $app = app();
  $controller = $app->make('App\Http\Controllers\HomeController');
  return $controller->callAction('test', $parameters = array());

});
Route::get('test', 'Auth\LoginController@test');*/

Route::get('new-design', 'AdminController@newDesign');

Route::get('rcmc-admin/{id}/{condo_id}', 'AdminController@subAdmin');
Route::get('admin/add-rcmc/{id}/{condo_id}', 'AdminController@addSubAdminPage');
Route::post('admin/add-new-subadmin', 'AdminController@addNewSubAdmin');
Route::get('admin/deletesubadmin/{id}', 'AdminController@deletesubAdmin');


//Route::get('email', 'EmailController@index');
Route::post('rcmc-changepassword', 'AdminController@UpdateRcMcUser');
Route::get('cell_number_availability', 'HomeController@CheckMobileNumber');


Route::get('logout', 'Auth\LoginController@logout');
Route::get('all-user', 'AdminController@getAllUsers');
Route::get('taman-condo', 'AdminController@getAllProperty');
Route::get('add-taman-condo', 'AdminController@addNewProperty');
Route::post('admin/update-property', 'AdminController@updateProperty');


Route::post('admin/addNewUser', 'AdminController@saveNewUser');
Route::get('admin/new-user', 'AdminController@addNewUser');
Route::get('admin/new-resident-user', 'AdminController@addNewResidentUser');
Route::get('admin/new-tenant-user', 'AdminController@addNewTenantUser');

Route::get('resident-user/{id}', 'AdminController@getResidentUsers');
Route::get('tenant-user/{id}', 'AdminController@getTenantUsers');

Route::get('admin/actionchange/{id}/{status}', 'AdminController@actionChange');
Route::get('admin/familyactionchange/{id}/{status}', 'AdminController@familyActionChange');

Route::get('pdfview',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));

Route::get('deleteproperty/{id}', 'AdminController@deleteProperty');
Route::post('admin/add-property', 'AdminController@sendProperty');
Route::get('image-upload-with-validation',['as'=>'getimage','uses'=>'ImageController@getImage']);
Route::post('image-upload-with-validation',['as'=>'postimage','uses'=>'ImageController@postImage']);

Route::get('admin/deletecontact/{id}', 'AdminController@deleteContact');
Route::get('admin/deletenotice/{id}', 'AdminController@deleteNotice');

Route::get('admin/emergancy-contact/{id}', 'AdminController@emergancyContactIndex');
Route::get('admin/all-user/{id}', 'AdminController@getAllUsers');
Route::get('admin/add-contact/{id}', 'AdminController@addContactIndex');
Route::get('deletecomplaint/{id}', 'AdminController@deleteComplaint');

Route::get('admin/my-family/{id}/{user_id}', 'AdminController@getMyFamilyByUserID');
Route::get('admin/report-complaint/{id}', 'AdminController@getReportComplaintByPtdId');
Route::get('admin/visitor/{id}', 'AdminController@getVisitorByPtdId');
Route::get('admin/today-visitor/{id}', 'AdminController@todayVisitorByPtdId');


Route::get('admin/ann-notice-board/{id}', 'AdminController@getAnnounceNoticeByPtdId');
Route::get('admin/maintenance-fee/{id}/{user_id}', 'AdminController@getMaintenanceFeeByUserID');
Route::get('admin/add-maintenance-fees/{id}/{user_id}', 'AdminController@addMaintenanceFeeByUserID');
Route::post('admin/add-maintenancefees', 'AdminController@addMaintenanceFess');
Route::post('admin/update-maintenancefees', 'AdminController@updateMaintenanceFees');

Route::get('admin/inbox/{id}', 'AdminController@getInboxByPtdId');
Route::get('admin/sent/{id}', 'AdminController@getSentByPtdId');

Route::get('admin/new-message/{id}', 'MessageController@newMessage');
Route::post('admin/send-message', 'MessageController@sendMessageToUser');

Route::get('admin/manage-property/{id}', 'AdminController@managePropertyById');

Route::get('complaint', 'AdminController@getComplaintIndex');
Route::post('complaint-update', 'AdminController@UpdateComplaint');

Route::post('Updatevisitor', 'AdminController@Updatevisitor');
Route::get('admin/deletevisitor/{id}', 'AdminController@deletevisitor');

Route::post('emergency-contact-update', 'AdminController@UpdateEmergencyContact');
Route::get('admin/change-contact-status/{id}/{status}', 'AdminController@changeContactStatus');

Route::get('admin/insurance/{id}', 'AdminController@getInsurance');
Route::get('admin/handyman/{id}', 'AdminController@getHandyman');

Route::post('handyman-contact-update', 'AdminController@UpdateHandymanContact');
Route::get('admin/add-handyman-contact/{id}', 'AdminController@addHandymanContactIndex');
Route::get('admin/deleteHandymancontact/{id}', 'AdminController@deleteHandymanContact');

Route::get('admin/e-flyer-coupon/{id}', 'AdminController@getCoupon');
Route::get('admin/add-coupon/{id}', 'AdminController@addCouponIndex');
Route::post('coupon-update', 'AdminController@UpdateCoupon');
Route::get('admin/deletecoupon/{id}', 'AdminController@deleteCoupon');


Route::get('admin/add-notice/{id}', 'AdminController@addNoticeIndex');
Route::post('notice-update', 'AdminController@UpdateNotice');
Route::post('save-notice', 'AdminController@saveNotice');


Route::get('admin/change-password','AdminController@changePassword');
Auth::routes();

Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');

