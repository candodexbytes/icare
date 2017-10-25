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
}
