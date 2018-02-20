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
//Propery check middleware
Route::group(['middleware' => ['web']], function () {
Route::get('add-taman-condo', 'AdminController@addNewProperty');
Route::get('new-design', 'AdminController@newDesign');
//change routes
Route::get('set', 'AdminController@set');
Route::get('set-property/{id}/{type}', 'AdminController@setproperty');
Route::get('admin/manage-property', 'AdminController@managePropertyById');
Route::get('admin/unit', 'AdminController@getUnit');
Route::get('admin/all-user', 'AdminController@getAllUsers');
Route::get('resident-user', 'AdminController@getResidentUsers');
Route::get('tenant-user', 'AdminController@getTenantUsers');
Route::get('admin/emergancy-contact', 'AdminController@emergancyContactIndex');
Route::get('admin/report-complaint', 'AdminController@getReportComplaintByPtdId');
Route::get('admin/ann-notice-board', 'AdminController@getAnnounceNoticeByPtdId');
Route::get('admin/insurance', 'AdminController@getInsurance');
Route::get('admin/handyman', 'AdminController@getHandyman');
Route::get('rcmc-admin', 'AdminController@subAdmin');
Route::get('admin/add-handyman-contact', 'AdminController@addHandymanContactIndex');
Route::get('admin/e-flyer-coupon', 'AdminController@getCoupon');
Route::get('admin/add-coupon', 'AdminController@addCouponIndex');
Route::get('admin/inbox', 'AdminController@getInboxByPtdId');
Route::get('admin/sent', 'AdminController@getSentByPtdId');
Route::get('admin/new-message', 'MessageController@newMessage');
Route::get('admin/add-rcmc/', 'AdminController@addSubAdminPage');
Route::get('admin/deleteemail/{id}', 'AdminController@deleteEmail');
Route::get('admin/add-unit', 'AdminController@addUnit');
Route::get('admin/visitor', 'AdminController@getVisitorByPtdId');
Route::get('admin/maintenance', 'AdminController@maintenanceDetail');
Route::get('admin/add-notice', 'AdminController@addNoticeIndex');
Route::get('admin/security-link', 'AdminController@securityLink');
Route::get('admin/add-contact/', 'AdminController@addContactIndex');
Route::get('admin/add-security/', 'AdminController@addSecurity');
// end change routes
Route::get('rcmc-admin/{id}/{condo_id}', 'AdminController@subAdmin');
Route::get('admin/add-rcmc/{id}/{condo_id}', 'AdminController@addSubAdminPage');
Route::post('admin/add-new-subadmin', 'AdminController@addNewSubAdmin');
Route::get('admin/deletesubadmin/{id}', 'AdminController@deletesubAdmin');

Route::get('admin/check-cellnumber-nric-data/{ptd_id}/{nric}/{cell_number}/{unit_id}', 'HomeController@CheckNricNumber');


//Route::get('email', 'EmailController@index');
Route::post('rcmc-changepassword', 'AdminController@UpdateRcMcUser');
Route::get('cell_number_availability', 'HomeController@CheckMobileNumber');
Route::get('cell_number_exist', 'HomeController@CheckMobileNumberExist');
// Route::get('nric_number_availability', 'HomeController@CheckNricNumber');


Route::get('logout', 'Auth\LoginController@logout');
Route::get('all-user', 'AdminController@getAllUsers');
Route::get('taman-condo', 'AdminController@getAllProperty');

Route::post('admin/update-property', 'AdminController@updateProperty');


Route::post('admin/addNewUser', 'AdminController@saveNewUser');
Route::post('admin/addNewUnit', 'AdminController@saveNewUnit');
Route::post('admin/addNewUnitUser', 'AdminController@saveNewUnitUser');
Route::post('admin/addNewSecurity', 'AdminController@saveNewSecurity');
Route::get('admin/new-user', 'AdminController@addNewUser');
Route::get('admin/new-resident-user', 'AdminController@addNewResidentUser');
Route::get('admin/new-tenant-user', 'AdminController@addNewTenantUser');
Route::post('admin/update-unit', 'AdminController@UpdateUnit'); 


Route::get('admin/user-login', 'AdminController@userlogin');
Route::get('admin/actionchange/{id}/{status}', 'AdminController@actionChange');
Route::get('admin/familyactionchange/{id}/{status}', 'AdminController@familyActionChange');
Route::get('admin/unitactionchange/{id}/{status}', 'AdminController@unitActionChange');  

Route::get('pdfview',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));

Route::get('deleteproperty/{id}', 'AdminController@deleteProperty');

Route::post('admin/add-property', 'AdminController@sendProperty');
Route::get('image-upload-with-validation',['as'=>'getimage','uses'=>'ImageController@getImage']);
Route::post('image-upload-with-validation',['as'=>'postimage','uses'=>'ImageController@postImage']);

Route::get('admin/deletecontact/{id}', 'AdminController@deleteContact');
Route::get('admin/deletenotice/{id}', 'AdminController@deleteNotice');




Route::get('deletecomplaint/{id}', 'AdminController@deleteComplaint');

Route::get('admin/my-family/{id}/{user_id}', 'AdminController@getMyFamilyByUserID');
Route::get('admin/my-family-data/{property_id}/{user_id}', 'AdminController@getMyFamilyData');
Route::get('admin/unit-user-data/{property_id}/{unit_id}', 'AdminController@getMyUnitUserData');

Route::get('admin/report-complaint/{id}', 'AdminController@getReportComplaintByPtdId');

Route::get('admin/today-visitor/{id}', 'AdminController@todayVisitorByPtdId');



Route::get('admin/maintenance-fee/{id}/{user_id}', 'AdminController@getMaintenanceFeeByUserID');
Route::get('admin/add-maintenance-fees/{id}/{user_id}', 'AdminController@addMaintenanceFeeByUserID');
Route::post('admin/add-maintenancefees', 'AdminController@addMaintenanceFess');
Route::post('admin/update-maintenancefees', 'AdminController@updateMaintenanceFees');
Route::post('admin/deletesecurity', 'AdminController@deletesecurity');
Route::post('admin/updateSecurity', 'AdminController@updateSecurity');





Route::post('admin/send-message', 'MessageController@sendMessageToUser');



Route::get('complaint', 'AdminController@getComplaintIndex');
Route::post('complaint-update', 'AdminController@UpdateComplaint');

Route::post('Updatevisitor', 'AdminController@Updatevisitor');
Route::get('admin/deletevisitor/{id}', 'AdminController@deletevisitor');

Route::post('emergency-contact-update', 'AdminController@UpdateEmergencyContact');
Route::get('admin/change-contact-status/{id}/{status}', 'AdminController@changeContactStatus');
Route::post('admin/actionSecurity', 'AdminController@changeSecurityStatus');



Route::post('handyman-contact-update', 'AdminController@UpdateHandymanContact');
Route::post('resident-user-update', 'AdminController@UpdateResidentUser');
Route::post('tenant-user-update', 'AdminController@UpdateTenantUser');

Route::get('admin/deleteHandymancontact/{id}', 'AdminController@deleteHandymanContact');



Route::post('coupon-update', 'AdminController@UpdateCoupon');
Route::get('admin/deletecoupon/{id}', 'AdminController@deleteCoupon');
Route::get('admin/deletemaintenancefee/{id}', 'AdminController@deleteMaintenanceFee');


Route::post('notice-update', 'AdminController@UpdateNotice');
Route::post('save-notice', 'AdminController@saveNotice');
Route::post('admin/deleteunit', 'AdminController@deleteUnit');

Route::get('admin/change-password','AdminController@changePassword');
Route::get('security/in/{ptd_id}','SecurityController@inVisitor');
Route::get('security','SecurityController@index');
Route::get('security/security-visitor','SecurityController@securityVisitor');
Route::get('security/visitor-list','SecurityController@visitorList');
Route::get('security/visitor-pass/{id}','SecurityController@visitorPass');
Route::get('security/register-pass','SecurityController@registerPassbook');
Route::get('security/pass-detail/{visitors_id}','SecurityController@detailPassbook');
Route::get('security/change-visitor_status/{visitors_id}','SecurityController@changeSatus');
Route::post('save-visitor','SecurityController@addpassbook');
Route::get('admin/gettransactiondata/{maintenance_id}/{ptd_id}','AdminController@getTransactionData');
Route::get('admin/security-link/{id}', 'AdminController@securityLink');

//Route::get('admin/my-family-unit-data/{ptd_id}/{property_unit_id}', 'AdminController@getMyFamilyUnitData');


Route::get('admin/add-unit-user/{ptd_id}/{property_unit_id}', 'AdminController@addUnitUser');
Route::get('admin/get-user-unit/{unit_id}/{user_id}', 'AdminController@getUserUnit');
Auth::routes();

Route::get('dashboard', 'AdminController@index')->name('admin.dashboard');


Route::get('admin/maintenance/{id}', 'AdminController@invoiceCreate');

Route::post('admin/add-maintenance', 'AdminController@addMaintenance');
Route::get('admin/property-user-data/{ptd_id}/{unit_id}', 'AdminController@getAllPropertyData');
Route::get('admin/property-data/{ptd_id}/{unit_id}/{id}', 'AdminController@getPropertyData');

Route::get('admin/account', 'AdminController@accountTransaction');
Route::get('admin/withdrawal-amount/{amount}', 'AdminController@withdrawalAmount');
Route::get('admin/setting', 'AdminController@accountSetting');
Route::post('admin/save-setting', 'AdminController@saveSetting');


Route::post('admin/remove-teman-from-management', 'AdminController@removeTemanfromManagement'); 
Route::post('admin/delete-teman', 'AdminController@deleteTeman'); 
});
Route::post('admin/save-withdrawal', 'AdminController@saveWithdrawDetail');
Route::post('admin/reminder', 'AdminController@userRemnider');

Route::post('update-invite-status', 'CronController@updateInviteStatus'); 