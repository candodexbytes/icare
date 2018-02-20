<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\Push;
use App\Models\Visitor;
use Twilio;
use Nexmo;

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

        $postData = $request->all();

        if(empty($postData['cell_number'])) $errors[] = "cell_number ";
        if(empty($postData['token'])) $errors[] = "token ";
        if(empty($postData['country_code'])) $errors[] = "country_code ";
      
        if(!empty($errors)) {
            $message = array("Please sent in the following fields:");
            foreach($errors as $error) {
                $message[] = $error;
            }
            $message = join(',', $message);
            return response()->json(['response' => false , 
                'message' =>  $message              
            ]);
        }

        $Otp_obj = new Otp;
    	$Visitor_obj = new Visitor;

        $token = base64_decode($postData['token']);
        
        $mobile_number = $postData['cell_number'] ;
        $country_code = $postData['country_code'] ;
        
        if($token == 'otp-genrate'){
            $six_digit_random_number = mt_rand(100000, 999999);
           
            // $message ='Your Condo Management Login OTP is: '.$six_digit_random_number.'';
            $save_array = array(
                                'cell_number'  => $mobile_number,
                                'country_code'  => $country_code,
                                'otp'    => $six_digit_random_number,
                                'otp_create_date'     => date("Y-m-d h:i:sa")
                                );   

            $save = $Otp_obj->save_otp($save_array);

            if($save == 2){
              return  response()->json(['response'=>'2']);
            }else{
                $data = $Visitor_obj->getVisitorByCellNumber($mobile_number);

                if (strlen($data->password) > 0) {
                    return response()->json(['response'=>'3', 'visitor_id'=>$data->id, 'data' => $data]);
                } else {
                    $message = 'Your six digit OTP for mobile number verification on the ICares mobile application is '.$six_digit_random_number.'';
                    $Push_Model = new Push;

                    if ($data->country_code) {
                        $country_code = $data->country_code;
                        $push = $Push_Model->sendVisitorOtp($mobile_number, $country_code, $message);
                    } else{
                        
                        $push = $Push_Model->sendOtp($mobile_number, $message);
                    }

                    if ($push == 1) {
                        return response()->json(['response'=>'1', 'visitor_id'=>$data->id, 'data' => $data]);
                    } else {
                        return response()->json(['response'=>'0']);
                    }
                    return  response()->json(['response'=>'1', 'visitor_id'=>$data->id, 'data' => $data]);    
                }
            }
            
        }
        
    	return response()->json(['response'=>'0']);
    }
    public function otpGenrateVisitor(Request $request)
    {
        $Otp_obj = new Otp;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        $cell_number = $postData['cell_number'] ;

        if ($token == 'otp-genrate') {
            $checkNumber = $Otp_obj->checkVisitorNumber($cell_number);
           
            if (count($checkNumber) > 0) {
                $six_digit_random_number = substr($cell_number, -4);
            
                $message ='Your Condo Management Login OTP is: '.$six_digit_random_number.'';
                $save_array = array(
                                    'cell_number'  => $cell_number,
                                    'otp'    => $six_digit_random_number,
                                    'otp_create_date'     => date("Y-m-d h:i:s a")
                                    );   
                $save = $Otp_obj->save_Visitorotp($save_array);
                
                if($save == 1){
                  return  response()->json(['response'=>'1']);
                }
            } else {
                return response()->json(['response'=>'2', 'message' => 'Number not exist']);
            }
        }
        
        return response()->json(['response'=>'0']);
    }
    
}
