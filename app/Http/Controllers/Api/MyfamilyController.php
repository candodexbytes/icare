<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Myfamily;


class MyfamilyController extends Controller
{
    
    public function index(Request $request )
    {
    	$token_show = base64_encode('delete-image');
        $postData = $request->all();
        $myfamily_obj = new Myfamily;
        
        
        if(isset($postData['token'])){
            $token = base64_decode($postData['token']);
            if($token == 'my-family'){
                $user_id = $postData['user_id'];
                $ptd_id = $postData['ptd_id'];
                $data = $property_obj->get_family($ptd_id,$user_id);
                if($data){
                    return response()->json(['response'=>'1','data' => $data]);
                }else{
                    return response()->json(['response'=>'1','data' => $data]);
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
    public function getAllFamily(Request $request)
    {
        $postData = $request->all();
        $myfamily_obj = new Myfamily;
        if(isset($postData['token'])){
            $token = base64_decode($postData['token']);
            if($token == 'my-family'){
                $user_id = $postData['user_id'];
                $ptd_id = $postData['ptd_id'];
                $data = $myfamily_obj->get_family($ptd_id,$user_id);
                if($data){
                    return response()->json(['response'=>'1','data' => $data]);
                }else{
                    return response()->json(['response'=>'1','data' => $data]);
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

    	$myfamily_obj = new Myfamily;
        if($token == 'my-family'){

            $user_id    = $postData['user_id'];
            $ptd_id     = $postData['ptd_id'];
            $type       = $postData['type'];
            $image      = $postData['image'];

            $dataArray = array(
                    'ptd_id'        => $ptd_id,
                    'user_id'       => $user_id,
                    'type'          => $type,
                    'image'         => $image
                );

            $data_id = $myfamily_obj->save_image($dataArray);
            return response()->json(['response'=>'1','id' => $data_id]);

        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }
    public function deleteImage(Request $request)
    {
        $postData = $request->all();
        $token = base64_decode($postData['token']);  
        $myfamily_obj = new Myfamily;
        if($token == 'delete-image'){
            $id    = $postData['id'];
            $data_id = $myfamily_obj->delete_image($id);
            return response()->json(['response'=>'1']);
        }
        return response()->json(['response'=>'0']);
    }
    
}
