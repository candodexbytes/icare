<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Myfamily;


class MyfamilyController extends Controller
{
    
    public function index(Request $request )
    {
    	$token_show = base64_encode('my-family');
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
                $unit_id = $postData['unit_id'];
                $property_id = $postData['property_id'];
                $data = $myfamily_obj->get_family($ptd_id,$user_id,$unit_id, $property_id);
                if($data){
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
    	$myfamily_obj = new Myfamily;
        
        if($token == 'my-family'){

            $user_id        = $postData['user_id'];
            $ptd_id         = $postData['ptd_id'];
            $unit_id        = $postData['unit_id'];
            $name           = $postData['name'];
            $relationship   = $postData['relationship'];
            $gender         = $postData['gender'];
            $phone          = $postData['phone'];
            $phone2         = $postData['phone2'];
            $car_model      = $postData['car_model'];
            $car_number     = $postData['car_number'];
            $type           = $postData['type'];
            $image          = $postData['image'];
            $nric           = $postData['nric'];
            $email          = $postData['email'];
            $address        = $postData['address'];
            $colour         = $postData['colour'];
            $property_id    = $postData['property_id'];
            $country_code    = $postData['country_code'];

            $dataArray = array(
                    'ptd_id'        => $ptd_id,
                    'user_id'       => $user_id,
                    'unit_id'       => $unit_id,
                    'name'          => $name,
                    'relationship'  => $relationship,
                    'gender'        => $gender,
                    'car_model'     => $car_model,
                    'car_number'    => $car_number,
                    'phone'         => $phone,
                    'phone2'        => $phone2,
                    'type'          => $type,
                    'nric'          => $nric,
                    'email'         => $email,
                    'address'       => $address,
                    'colour'        => $colour,
                    'property_id'   => $property_id,
                    'image'         => $image,
                    'country_code'  => $country_code
                );

            $data_id = $myfamily_obj->save_image($dataArray);
            return response()->json(['response'=>'1','id' => $data_id]);

        }else{
            return response()->json(['response'=>'0']);
        }
        return response()->json(['response'=>'0']);
    }

    public function myFamilyUpdate(Request $request)
    {
        $postData = $request->all();
        $token = base64_decode($postData['token']);

        $myfamily_obj = new Myfamily;
        if($token == 'my-family'){

            $id             = $postData['id'];
            $name           = $postData['name'];
            $relationship   = $postData['relationship'];
            $gender         = $postData['gender'];
            $phone          = $postData['phone'];
            $phone2         = $postData['phone2'];
            $car_model      = $postData['car_model'];
            $car_number     = $postData['car_number'];
            $image          = $postData['image'];
            $nric           = $postData['nric'];
            $email          = $postData['email'];
            $address        = $postData['address'];
            $colour         = $postData['colour'];
            if(empty($image)){
                $dataArray = array(
                    'name'          => $name,
                    'relationship'  => $relationship,
                    'gender'        => $gender,
                    'car_model'     => $car_model,
                    'car_number'    => $car_number,
                    'phone'         => $phone,
                    'phone2'        => $phone2,
                    'nric'          => $nric,
                    'email'         => $email,
                    'address'       => $address,
                    'colour'        => $colour
                );
            }else{
                $dataArray = array(
                    'name'          => $name,
                    'relationship'  => $relationship,
                    'gender'        => $gender,
                    'car_model'     => $car_model,
                    'car_number'    => $car_number,
                    'phone'         => $phone,
                    'phone2'        => $phone2,
                    'nric'          => $nric,
                    'email'         => $email,
                    'address'       => $address,
                    'colour'        => $colour,
                    'image'         => $image
                );
            }
            

            $data_id = $myfamily_obj->updateMyfamily($dataArray,$id);
            return response()->json(['response'=>'1']);

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
    public function getFamilyDataById($id)
    {
        $myfamily_obj = new Myfamily;
        $data = $myfamily_obj->getFamilyById($id);
        if(count($data) > 0){
            return response()->json(['response'=>'1','data' => $data]);
        }else{
            return response()->json(['response'=>'2']);
        }
        
        return response()->json(['response'=>'0']);
    }
    
    
}
