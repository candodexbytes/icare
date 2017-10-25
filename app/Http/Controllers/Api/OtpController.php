<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use Twilio;

class OtpController extends Controller
{
    
    public function index(Request $request )
    {
    	$token = base64_encode('otp-genrate');
        echo $token;die();
        $Otp_obj = new Otp;
    	return response()->json(['response'=>'1']);
    }
	public function store(Request $request)
    {
    	$Otp_obj = new Otp;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        $mobile_number = $postData['mobile_number'] ;
        
        if($token == 'otp-genrate'){
            $six_digit_random_number = mt_rand(100000, 999999);
            $message ='Your Condo Management Login OTP is: '.$six_digit_random_number.'';

            $save_array = array(
                                'mobile_number'  => $mobile_number,
                                'otp'    => $six_digit_random_number,
                                'otp_create_date'     => date("Y-m-d h:i:sa")
                                );   
            $save = $Otp_obj->save_otp($save_array);
            if($save == 2){
              return  response()->json(['response'=>'2']);
            }else{
                Twilio::message($mobile_number, $message);
                return  response()->json(['response'=>'1']);    
            }
            
        }
        
    	return response()->json(['response'=>'0']);
    }
}
