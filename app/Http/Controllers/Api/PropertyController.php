<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;


class PropertyController extends Controller
{
    
    public function index(Request $request )
    {
    	$token = base64_encode('all-property');
        echo $token;die();
    	return response()->json(['response'=>'0']);
    }
	
    public function store(Request $request)
    {
        $postData = $request->all();
        $token = base64_decode($postData['token']);

    	$property_obj = new Property;
        if($token == 'all-property'){
          
            $data = $property_obj->get_property();
            return response()->json(['response'=>'1','data' => $data]);

        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }

    public function getUserProperty(Request $request){
       
        $property_obj = new Property;
        $postData = $request->all();
        
        $token = $postData['token'];
        $user_id = $postData['user_id'];
        if($token == 'YWxsLXByb3BlcnR5'){
          
            $data = $property_obj->get_user_property($postData['user_id']);
            
            return response()->json(['response'=>'1','data' => $data]);

        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }

    public function getPropertyByNumber(Request $request){
       
        $property_obj = new Property;
        $postData = $request->all();

        $number = $postData['number'];
        if($number){
            $data = $property_obj->get_property_by_number($number);
            if (count($data) > 0) {
                return response()->json(['response'=>'1','data' => $data]);    
            } else {
                return response()->json(['response'=>'0']);
            }
        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }

    public function getPropertyUnits(Request $request){
       
        $postData = $request->all();

        if(empty($postData['property_id'])) $errors[] = "property_id";           

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
        $property_obj = new Property;
        $property_id = $postData['property_id'];

        if($property_id){
            $units = $property_obj->get_units_by_property($property_id);

            if (count($units) > 0) {
                return response()->json(['response'=>true,'units' => $units]);    
            } else {
                return response()->json(['response'=>false]);
            }

        }else{
            return response()->json(['response'=>false]);
        }
        return response()->json(['response'=>false]);
    }
}
