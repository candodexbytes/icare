<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class BasicController extends Controller
{
    
    public function index(Request $request )
    {
    	$token = base64_encode('complaint');
        
        echo $token;die();
        $Login_obj = new Login;
    	return response()->json(['response'=>'1']);
    }
	public function store(Request $request)
    {
    	$admin_obj = new Admin;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        if($token == 'emergency-information'){
            $ptd_id = $postData['ptd_id'];
            $property_id = $postData['property_id'];
            $get_record = $admin_obj->get_emergencyContact($property_id);
            if(count($get_record) > 0){
                return response()->json(['response'=>'1','contact'=>$get_record]);
            }else{
                return response()->json(['response'=>'2']);
            }
            
        }   
        
    	return response()->json(['response'=>'0']);
    }
    public function getNotice(Request $request)
    {
        $admin_obj = new Admin;
        $postData = $request->all();

        $ptd_id = $postData['ptd_id'];
        $property_id = $postData['property_id'];
        $get_record = $admin_obj->getNoticeByPtdId($ptd_id, $property_id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }
    public function getNoticeById($id)
    {
        $admin_obj = new Admin;
    
        $get_record = $admin_obj->getNoticeById($id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }

    public function getHandyman(Request $request)
    {
        $admin_obj = new Admin;
        $postData = $request->all();
        
        $token = base64_decode($postData['token']);
        if($token == 'handyman'){
            $ptd_id = $postData['ptd_id'];
            $property_id = $postData['property_id'];
            $get_record = $admin_obj->getHandymanByPtdId($ptd_id, $property_id);
            if(count($get_record) > 0){
                return response()->json(['response'=>'1','data'=>$get_record]);
            }else{
                return response()->json(['response'=>'2']);
            }
        }
        return response()->json(['response'=>'0']);
    }

    public function getHandymanDetail(Request $request)
    {
        $admin_obj = new Admin;
        $postData = $request->all();

        $handyman_id = $postData['handyman_id'];

        $get_record = $admin_obj->getHandymanById($handyman_id);

        if(count($get_record) > 0){
            return response()->json(['response'=>'1','handyman'=>$get_record[0]]);
        }
        
        return response()->json(['response'=>'0']);
    }

    public function getCoupon(Request $request)
    {
        $admin_obj = new Admin;
        $postData = $request->all();
        $ptd_id = $postData['ptd_id'];
        $property_id = $postData['property_id'];
        $get_record = $admin_obj->getCouponByPtdId($ptd_id, $property_id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }

    public function getCouponDetail(Request $request){
        $admin_obj = new Admin;
        $postData = $request->all();

        $coupan_id = $postData['coupan_id'];
        $get_record = $admin_obj->getCouponDetailById($coupan_id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }
    public function getComplaintById($id)
    {
        $admin_obj = new Admin;
    
        $get_record = $admin_obj->getComplaintById($id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }

    public function getMaintenanceFees(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;
        $ptd_id = $postData['ptd_id'];
       
        $get_record = $admin_obj->getMaintenanceFeesByDb($ptd_id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }


    public function getUserMaintenanceFees(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;

        $ptd_id = $postData['ptd_id'];
        $property_id = $postData['property_id'];
        $user_id = $postData['user_id'];
        $unit_id = $postData['unit_id'];
       
        $get_record = $admin_obj->getUserMaintenanceFeesByDb($ptd_id, $unit_id, $property_id);
        
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }

    public function getMaintenanceDetailById(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        $get_record = $admin_obj->getMaintenanceFeesById($id);
        if(count($get_record) > 0){
            return response()->json(['response'=>'1','data'=>$get_record]);
        }else{
            return response()->json(['response'=>'0']);
        }
    }

    public function transactionDetail(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;

        $user_id = $postData['user_id'];
        $maintenance_id = $postData['maintenance_id'];
        $amount = $postData['amount'];
        $slug = $postData['slug'];
        $status = $postData['status'];
        $bill_id = $postData['bill_id'];

        // $check = $admin_obj->checkMaintenance($maintenance_id, $user_id);
        // if (count($check) > 0) {
        //     return response()->json(['response'=>'0']);
        // } else {
        $save_record = $admin_obj->savetransactionDetail($user_id, $maintenance_id, $amount, $slug, $status, $bill_id); 
        
        if ($save_record == 1) {
            return response()->json(['response'=>'1']);
        } 
        return response()->json(['response'=>'0']);
        // }
    }

    public function gettransactionDetail(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;

        $transaction_id = $postData['transaction_id'];

        $detail = $admin_obj->gettransactiondetail($transaction_id);

        return response()->json(['response'=>'1', 'data'=> $detail]);
        
    }

    public function addCount(Request $request){
        $postData = $request->all();
        // print_r($postData);
        // die;
        $errors = array();
        if(empty($postData['user_id'])) $errors[] = "user_id";
        //if(empty($postData['page_id'])) $errors[] = "page_id";
        if(empty($postData['type'])) $errors[] = "type";       

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
        $admin_obj = new Admin;

        $detail = $admin_obj->insertCountData($postData);

        if ($detail == 1) {
            return response()->json(['response'=>true]);
        }
        return response()->json(['response'=>false]);
    }
    
}
