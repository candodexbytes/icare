<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Push;


class LoginController extends Controller
{
    
    public function index(Request $request )
    {
        $token = base64_encode('api-login');
        
        echo $token;die();
        $Login_obj = new Login;
        return response()->json(['response'=>'1']);
    }
    public function store(Request $request)
    {
        $Login_obj = new Login;
        $Push_obj = new Push;
        $postData = $request->all();

        $token = base64_decode($postData['token']);
        $nric_number = $postData['nric'] ;
        $mobile_number = $postData['mobile_number'] ;
        $type = $postData['type'] ;
        $country_phone_code = $postData['country_phone_code'] ;

        if($token == 'api-login'){

            $checkActive = $Login_obj->check_resident_active($nric_number, $mobile_number, $type, $country_phone_code);
            
            if ($checkActive == 0) {
                return response()->json(['response' => '4' , 
                    'message' =>  "Dear Resident, sorry to inform that your account was deacctivated, please contact your management office for further clarification, and looking forward to serving you soon."          
                ]);
            }


            $check_nric_mnumber = $Login_obj->nric_check($nric_number, $mobile_number, $type, $country_phone_code);

            $six_digit_random_number = mt_rand(100000, 999999);
            if ($check_nric_mnumber == 1 ) {
                
                $message = 'Your six digit OTP for mobile number verification on the ICares mobile application is '.$six_digit_random_number.'';
                $push = $Push_obj->sendVisitorOtp($mobile_number, $country_phone_code, $message);
                
                $data = $Login_obj->setTemanOTP($nric_number, $mobile_number, $type, $six_digit_random_number, $country_phone_code);
                return response()->json(['response'=>'1']);
            } else if ($check_nric_mnumber == 3) {
                return response()->json(['response'=>'3',
                    'message' =>  "Oops! Sorry, you are not registered in our database, please contact your management office for further clarification.\n See You inside Cheers"  
                ]);
            } else if ($check_nric_mnumber == 2) {
                return response()->json(['response'=>'2']);
            }
        }
        
        return response()->json(['response'=>'0']);
    }

    public function setTemanOTP(Request $request){ 
        $Login_obj = new Login;
        $Push_obj = new Push;
        $postData = $request->all();

        $login_type = $postData['login_type'] ;
        $mobile_number = $postData['mobile_number'] ;
        $nric = $postData['nric'] ;
        $country_phone_code = $postData['country_code'] ;

        $six_digit_random_number = mt_rand(100000, 999999);
        
        $data = $Login_obj->setTemanOTP($nric, $mobile_number, $login_type, $six_digit_random_number, $country_phone_code);

        if($data == 1){
            // $message = 'Your I-CARE otp: '.$six_digit_random_number;
            // $push = $Push_obj->sendOtp($mobile_number, $message);
            // return response()->json(['response'=>'1']);
        }else{
            return response()->json(['response'=>'2']);
        }
        $message = 'Your OTP for mobile number verification on the ICares mobile application is '.$six_digit_random_number;
        
        //$push = $Push_obj->sendOtp($mobile_number, $message);

        $push = $Push_obj->sendVisitorOtp($mobile_number, $country_phone_code, $message);
        if ($push == 1) {
            return response()->json(['response'=>'1']);
        } else {
            return response()->json(['response'=>'0']);
        }

        
    }

    public function temanLogin(Request $request){ 
        $Login_obj = new Login;
        $postData = $request->all();

        $login_type = $postData['login_type'] ;
        $mobile_number = $postData['mobile_number'] ;
        $nric = $postData['nric'] ;
        $password = md5($postData['temanPassword']);
        $temanOTP = $postData['temanOTP'] ;

        $data = $Login_obj->temanLogin($nric, $mobile_number, $login_type, $password, $temanOTP);

        if(count($data) == 1){
            if($data->status == 0){
                return response()->json(['response'=>'3']);
            } else {

                if ($data->password == '') {
                    $password_status = false;
                } else {
                    $password_status = true;
                }

                return response()->json(['response'=>'1','id'=>$data->id,'nric'=>$data->nric,'mobile_number'=>$data->mobile_number,'name'=>$data->name,'image'=>$data->image, 'ptd_id' => $data->ptd_id, 'property_id' => $data->property_id, 'password' => $password_status]);
            }
        }

        if($data == 1){
            return response()->json(['response'=>'1']);
        }else{
            return response()->json(['response'=>'2']);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function setPassword(Request $request){ 
        $Login_obj = new Login;
        $postData = $request->all();
       
        $login_type = $postData['login_type'] ;
        $password = md5($postData['password']) ;
        $user_id = $postData['user_id'] ;

        $data = $Login_obj->setPassword($login_type, $password, $user_id);
        if($data == 1){
            return response()->json(['response'=>'1', 'message'=>'Password update successfully']);
        }else{
            return response()->json(['response'=>'2']);
        }
       
        return response()->json(['response'=>'0']);
    }
}
