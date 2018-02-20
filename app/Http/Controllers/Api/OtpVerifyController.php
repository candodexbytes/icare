<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Otp;


class OtpVerifyController extends Controller
{
    
    public function index(Request $request )
    {
    	$token = base64_encode('otp-verify');
        echo $token;die();
    	return response()->json(['response'=>'1']);
    }
	public function store(Request $request)
    {
    	$Otp_obj = new Otp;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        $mobile_number = $postData['mobile_number'] ;
        
        if($token == 'otp-verify'){
            $otp = $postData['otp'] ;

            $verify_array = array(
                                'mobile_number'  => $mobile_number,
                                'otp'    => $otp,
                                );   
            $check = $Otp_obj->veryfy_otp($verify_array);
            if(isset($check)){
                return response()->json(['response'=>'1','id'=>$check->id,'mobile_number'=>$check->mobile_number,'nric'=>$check->nric]);
            }else{
                return response()->json(['response'=>'2']);
            }
            
        }
        
    	return response()->json(['response'=>'0']);
    }
    public function otpVerifyVisitor(Request $request)
    {
        $Otp_obj = new Otp;
        $postData = $request->all();

        if(empty($postData['token'])) $errors[] = "token";     
        if(empty($postData['cell_number'])) $errors[] = "cell_number";     
        if(empty($postData['otp'])) $errors[] = "otp";     
        if(empty($postData['country_code'])) $errors[] = "country_code";    

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

        $token = base64_decode($postData['token']);
        
        $cell_number = $postData['cell_number'] ;
        $country_code = $postData['country_code'] ;
        
        if($token == 'otp-verify'){
            $otp = $postData['otp'] ;

            $verify_array = array(
                                'cell_number'  => $cell_number,
                                'country_code'    => $country_code,
                                'otp'    => $otp
                                );   
            //print_r($verify_array['otp']);die();
            $check = $Otp_obj->veryfyVisitorotp($verify_array);
            if(count($check) > 0){
                return response()->json(['response'=>'1','data'=>$check]);
            }else{
                return response()->json(['response'=>'2']);
            }
            
        }
        
        return response()->json(['response'=>'0']);
    }
    
}
