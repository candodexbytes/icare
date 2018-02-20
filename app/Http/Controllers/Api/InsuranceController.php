<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;


class InsuranceController extends Controller
{
    
    public function index()
    {
    	$token_show = base64_encode('delete-insurance');
       
                echo $token_show;die();
       
    	return response()->json(['response'=>'0']);
    }
    
    public function getInsurance(Request $request )
    {
        $token_show = base64_encode('insurance');
        $postData = $request->all();
        $insurance_obj = new Insurance;
        
        
        if(isset($postData['token'])){
            $token = base64_decode($postData['token']);
            if($token == 'insurance'){
                $user_id = $postData['user_id'];
                $ptd_id = $postData['ptd_id'];
                $property_id = $postData['property_id'];
                $data = $insurance_obj->get_insurance($ptd_id,$user_id,$property_id);
                if(count($data)){
                    return response()->json(['response'=>'1','data' => $data]);
                }else{
                    return response()->json(['response'=>'2']);
                }
                return response()->json(['response'=>'0']);

            }else{
                return response()->json(['response'=>'0']);
            }
        }else{
                echo $token_show;die();
        }
        
        
        return response()->json(['response'=>'0']);
    }
	public function store(Request $request)
    {
        $postData = $request->all();
        $token = base64_decode($postData['token']);

    	$insurance_obj = new Insurance;
        if($token == 'insurance'){

            $user_id            = $postData['user_id'];
            $ptd_id             = $postData['ptd_id'];
            $car_model          = $postData['car_model'];
            $car_number         = $postData['car_number'];
            $insurance_company  = $postData['insurance_company'];
            $property_id        = $postData['property_id'];

            $dataArray = array(
                    'ptd_id'                => $ptd_id,
                    'user_id'               => $user_id,
                    'car_model'             => $car_model,
                    'car_number'            => $car_number,
                    'property_id'            => $property_id,
                    'insurance_company'     => $insurance_company
                );
            
            if(empty($postData['id'])) {
                $data_id = $insurance_obj->save_insurance($dataArray);
            }else{
                $data_id = $insurance_obj->update_insurance($dataArray,$postData['id']);
            }

            return response()->json(['response'=>'1']);

        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }
    public function deleteInsurance(Request $request)
    {
        $postData = $request->all();
        $token = base64_decode($postData['token']);  
        $insurance_obj = new Insurance;
        if($token == 'delete-insurance'){
            $id    = $postData['id'];
            $data_id = $insurance_obj->delete_insurance($id);
            return response()->json(['response'=>'1']);
        }
        return response()->json(['response'=>'0']);
    }
   
    
    
}
