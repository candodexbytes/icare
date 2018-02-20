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
Route::post('get-user-by-id', 'Api\UserController@getUserById');
Route::post('profile-image-update', 'Api\UserController@profileImageUpdate');
Route::post('profile-image-get', 'Api\UserController@profileImageGet');
Route::post('resident-detail-cellnumber', 'Api\UserController@residentDetailByNumber');
Route::resource('register', 'Api\RegisterController');
Route::resource('login', 'Api\LoginController');
Route::post('teman-otp', 'Api\LoginController@setTemanOTP');
Route::post('teman-login', 'Api\LoginController@temanLogin');
Route::resource('all-property', 'Api\PropertyController');
Route::post('user-property', 'Api\PropertyController@getUserProperty');
Route::post('get-properties-by-number', 'Api\PropertyController@getPropertyByNumber');
Route::resource('my-family', 'Api\MyfamilyController');
Route::post('my-family-update', 'Api\MyfamilyController@myFamilyUpdate');
Route::post('delete-image', 'Api\MyfamilyController@deleteImage');
Route::post('my-family/get', 'Api\MyfamilyController@getAllFamily');
Route::post('my-family/{id}', 'Api\MyfamilyController@getFamilyDataById');
Route::resource('otp-genrate', 'Api\OtpController');
Route::resource('otp-verify', 'Api\OtpVerifyController');
Route::resource('emergency-contact', 'Api\BasicController');
Route::post('otp-genrate-visitor', 'Api\OtpController@otpGenrateVisitor');
Route::post('otp-verify-visitor', 'Api\OtpVerifyController@otpVerifyVisitor');
Route::post('check-number', 'Api\VisitorController@checkNumber');
Route::post('check-nric', 'Api\VisitorController@checkNRIC');
Route::post('visitor-signup', 'Api\VisitorController@visitorSignup');
Route::post('complaint/get', 'Api\UserController@getComplaint');
Route::post('complaint', 'Api\UserController@postComplaint');
Route::post('complaint-cancel', 'Api\UserController@cancelComplaint');
Route::post('complaint/{id}', 'Api\BasicController@getComplaintById');
Route::post('insurance/get', 'Api\InsuranceController@getInsurance');
Route::resource('insurance', 'Api\InsuranceController');
Route::post('delete-insurance', 'Api\InsuranceController@deleteInsurance');
Route::post('handyman', 'Api\BasicController@getHandyman');
Route::post('handyman-detail', 'Api\BasicController@getHandymanDetail');
Route::post('notice', 'Api\BasicController@getNotice');
Route::post('notice/{id}', 'Api\BasicController@getNoticeById');
Route::post('maintenance-fees', 'Api\BasicController@getMaintenanceFees');
Route::post('user-maintenance-fees', 'Api\BasicController@getUserMaintenanceFees');
Route::post('save-transaction-detail', 'Api\BasicController@transactionDetail');
Route::post('get-transaction-detail', 'Api\BasicController@gettransactionDetail');
Route::post('e-coupon', 'Api\BasicController@getCoupon');
Route::post('coupan-detail', 'Api\BasicController@getCouponDetail');
Route::post('get-visitor', 'Api\VisitorController@getVisitorById');
Route::post('myvisitor-confirm', 'Api\UserController@myVisitorConfirm');
Route::post('get-visitor-by-cellnumber', 'Api\VisitorController@getVisitorByCellNumber');
Route::post('get-visitor-pass-detail', 'Api\VisitorController@getVisitorPassDetail');
Route::post('get-resident-request-detail', 'Api\VisitorController@getResidentRequestDetail');
Route::post('visitor-all-invitation', 'Api\VisitorController@getAllInvitation');
Route::post('visitor-all-passes', 'Api\VisitorController@getAllPasses');
Route::post('visitor-all-send-invitation', 'Api\VisitorController@getAllSendInvitation');
Route::post('favourite-visitor-edit', 'Api\VisitorController@favouriteVisitorStatusChange');
Route::post('request-invite-by-visitor', 'Api\VisitorController@requestInvitationByVisitor');
Route::post('get-visitor-all-request', 'Api\VisitorController@getVisitorAllRequest');
Route::post('get-resident-all-request', 'Api\VisitorController@getResidentAllRequest');
Route::post('update-visitor-profile', 'Api\VisitorController@updateVisitorProfile');
Route::post('visitor-detail-by-number', 'Api\VisitorController@getVisitorDetailByNumber');
Route::post('checkout-invite', 'Api\VisitorController@checkoutInvite');
//Route::post('sendinvitation-by-visitor', 'Api\VisitorController@sendInvitationByVisitor');
Route::resource('send-invitation', 'Api\VisitorController');
Route::post('get-user-visitor', 'Api\VisitorController@getVisitorList');
Route::post('get-resident-recent-invites', 'Api\VisitorController@getResidentRecentInvites');
Route::post('get-visitor-recent-request', 'Api\VisitorController@getVisitorRecentRequest');
Route::post('get-resident-favourite-invites', 'Api\VisitorController@getResidentFavouriteInvites');
Route::post('get-visitor-favourite-request', 'Api\VisitorController@getVisitorFavouriteRequest');
Route::post('accept-request', 'Api\VisitorController@acceptRequestById');
Route::post('reject-request', 'Api\VisitorController@rejectRequestById');
Route::post('maintenance-detail-id', 'Api\BasicController@getMaintenanceDetailById');
Route::post('maintenance-detail-id', 'Api\BasicController@getMaintenanceDetailById');
Route::post('get-message', 'Api\MessageController@getMessageByUserId');
Route::post('delete-message', 'Api\MessageController@deleteMessageById');
Route::post('change-message-status', 'Api\MessageController@ChangeMessageStatusById');
Route::resource('payment-get', 'Api\PaymentController');
Route::post('set-password', 'Api\LoginController@setPassword');
Route::post('about-us-terms', 'Api\UserController@getAboutUsOrTerms');

Route::post('security-login', 'Api\SecurityController@securityLogin'); 
Route::post('security-detail', 'Api\SecurityController@securityUserDetail'); 
Route::post('security-passes', 'Api\SecurityController@securityPasses'); 
Route::post('check-user-number', 'Api\UserController@checkusernumber'); 
Route::post('check-user-otp', 'Api\UserController@checkuserotp'); 
Route::post('get-all-counting', 'Api\UserController@getAllCounting'); 

Route::post('add-count', 'Api\BasicController@addCount');
Route::post('property-units', 'Api\PropertyController@getPropertyUnits');
Route::post('walkin-visitor', 'Api\VisitorController@walkinVisitor');
Route::post('set-visitor-password', 'Api\VisitorController@setVisitorPassword');
Route::post('check-visitor-password', 'Api\VisitorController@checkVisitorPassword');
/* visitor invite module */

/* resident invite */
Route::post('resident-visitor-invite', 'VisitorController@residentVisitorInvite');
Route::post('visitor-invite-resident', 'VisitorController@visitorInviteResident');
Route::post('resident-today-visitor', 'VisitorController@residnetTodayVisitor');
Route::post('visiting-card', 'VisitorController@visitingCard');
Route::post('security-visiting-card', 'VisitorController@securityVisitingCard');
Route::post('resident-recent-favourite', 'VisitorController@residentRecentFavourite');
Route::post('visitor-recent-favourite', 'VisitorController@visitorRecentFavourite');
Route::post('visitor-today-visits', 'VisitorController@visitorTodayVisits');
Route::post('resident-pending-invitation', 'VisitorController@residentPendingInvitation');
Route::post('visitor-pending-invitation', 'VisitorController@visitorPendingInvitation');
Route::post('visitor-sending-history', 'VisitorController@visitorAllInvite');
Route::post('resident-sending-history', 'VisitorController@residentAllInvite');
Route::post('update-visiting-status', 'VisitorController@updateVisitingStatus'); 
Route::post('resident-update-favourite-status', 'VisitorController@residentUpdateFavouriteStatus');
Route::post('visitor-update-favourite-status', 'VisitorController@visitorUpdateFavouriteStatus');
Route::post('country-code', 'VisitorController@getMobileCountryCode'); 
Route::post('get-resident-todays-passes', 'VisitorController@getResidentTodaysPasses'); 
Route::post('get-resident-passes', 'VisitorController@getResidentPasses'); 
Route::post('check-request', 'VisitorController@checkRequest'); 

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});