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
}
