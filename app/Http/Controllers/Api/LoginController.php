<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;


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
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        $mobile_number = $postData['mobile_number'] ;
        $password = md5($postData['password']);
        if($token == 'api-login'){
            $login_array = array('mobile_number' => $mobile_number,'password' => $password );
            $data_get = $Login_obj->login_check($login_array);
            if(count($data_get) == 1){
                return response()->json(['response'=>'1','id'=>$data_get->id,'nric'=>$data_get->nric,'mobile_number'=>$data_get->mobile_number]);
            }else{
                return response()->json(['response'=>'2']);
            }
        }
        
    	return response()->json(['response'=>'0']);
    }
}
