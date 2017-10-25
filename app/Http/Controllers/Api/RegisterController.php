<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;


class RegisterController extends Controller
{
    
    public function index(Request $request )
    {
        $token = base64_encode('api-register');
        echo $token;die();
    	$Register_obj = new Register;
    	return response()->json(['response'=>'0']);
    }
	public function store(Request $request)
    {
        $postData = $request->all();
       
        $nric_number = $postData['nric'] ;
        $password = md5($postData['password']);
        $mobile_number = $postData['mobile_number'];
        $token = base64_decode($postData['token']);
        $type = $postData['type'];

    	$register_obj = new Register;
        if($token == 'api-register'){
            $mobile_check = $register_obj->mobile_check($mobile_number);
            if($mobile_check == 1){
                return response()->json(['response'=>'2']);
            }else{
                $nric_check = $register_obj->nric_check($nric_number);
                if($nric_check == 1){
                    return response()->json(['response'=>'3']);
                }else{
                    $register_array = array('nric' => $nric_number,'mobile_number' => $mobile_number,'password' => $password,'type' => $type );
                    $save_record = $register_obj->register($register_array);
                    return response()->json(['response'=>'1','type'=>$type,'mobile_number'=>$mobile_number,'id'=>$save_record]);
                }
                
            }

        }else{
            return response()->json(['response'=>'0']);
        }
    	return response()->json(['response'=>'0']);
    }
}
