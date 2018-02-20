<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Login;
use App\Models\Otp;
use App\Models\Push;
use App\Models\Admin;
use App\Models\Invitation;


class UserController extends Controller
{
    
    public function index(Request $request )
    {
    	$token = base64_encode('complaint');
        
        echo $token;die();
    	return response()->json(['response'=>'0']);
    }
	public function store(Request $request)
    {
    	$user_obj = new User;
        $data = $user_obj->get_user();
    	return response()->json(['response'=>'1','data'=>$data]);
    }

    public function getUserById(Request $request)
    {
        $user_obj = new User;
        $postData = $request->all();
        $id = $postData['id'];
        $data = $user_obj->getUserById($id);
        if (count($data) > 0) {
            return response()->json(['response'=>'1','data'=>$data]);
        }
        return response()->json(['response'=>'0']);
    }

    public function residentDetailByNumber(Request $request)
    {
        $user_obj = new User;
        $postData = $request->all();
        $mobile_number = $postData['mobile_number'];
        $data = $user_obj->getResidentByNumber($mobile_number);
        if (count($data) > 0) {
            return response()->json(['response'=>'1','data'=>$data]);
        }
        return response()->json(['response'=>'0']);
    }
    
    public function postComplaint(Request $request)
    {
        $user_obj = new User;
        $postData = $request->all();
        $token = base64_decode($postData['token']);

        $user_id = $postData['user_id'];
        $ptd_id = $postData['ptd_id'];
        $remark = $postData['remark'];
        $image = $postData['image'];
        $property_id = $postData['property_id'];
        $unit_id = $postData['unit_id'];

        $last_record = $user_obj->get_last_record();
        //print_r($last_record);die();
        if(count($last_record) > 0){
            $ticket = time();
            
        }else{
            $ticket = time();
        }
        
        
        if($token == 'complaint'){
            $dataArray = array(
                    'user_id'  => $user_id,
                    'ptd_id'   => $ptd_id,
                    'ticket'   => $ticket,
                    'remark'   => $remark,
                    'image'    => $image,
                    'property_id'    => $property_id,
                    'unit_id'    => $unit_id
                    
                );
            $id = $user_obj->save_complaint($dataArray);
            return response()->json(['response'=>'1','id'=>$id,'ticket'=>$ticket]);
        }   
        
        return response()->json(['response'=>'0']);
    }

    public function getComplaint(Request $request)
    {
        //echo 'esf';die();
        $user_obj = new User;
        $postData = $request->all();

        $token = base64_decode($postData['token']);

        $user_id = $postData['user_id'];
        $ptd_id = $postData['ptd_id'];
        $property_id = $postData['property_id'];
        $unit_id = $postData['unit_id'];
       
        if($token == 'complaint'){
            $record = $user_obj->get_complaint($user_id, $ptd_id, $property_id, $unit_id);
            if(count($record) > 0){
                return response()->json(['response'=>'1','data'=>$record]);
            }else{
                return response()->json(['response'=>'2']);     
            }
            
        }   
        
        return response()->json(['response'=>'0']);
    }
    public function cancelComplaint(Request $request)
    {
        $user_obj = new User;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        $id = $postData['complaint_id'];

        
        if($token == 'cancel-complaint'){
            
            $id = $user_obj->cancel_complaint($id);
            return response()->json(['response'=>'1']);
        }   
        
        return response()->json(['response'=>'0']);
    }
    public function profileImageUpdate(Request $request)
    {
        //echo 'esf';die();
        $user_obj = new User;
        $postData = $request->all();
       
        $user_id = $postData['user_id'];
        $image = $postData['image'];
       
        $dataArray = array(
                    'image'  => $image
                );
        $record = $user_obj->updateProfile($dataArray,$user_id);
        if($record){
             return response()->json(['response'=>'1']);
        }    
        
        return response()->json(['response'=>'0']);
    }
    public function myVisitorConfirm(Request $request)
    {
        //echo 'esf';die();
        $day = date("d");
        $month = date("m");
        $year = date("y");
        
        $user_obj = new User;
        $postData = $request->all();
       
        $id = $postData['id'];
        $mycard_image = $postData['mycard_image'];
        $name = $postData['name'];
        $nric = $postData['nric'];
        $cell_number = $postData['cell_number'];
        // $car_model = $postData['car_model'];
        // $car_number = $postData['car_plate'];
        // $total_visitor = $postData['total_visitor'];

        // $visitor_code_genrate = 'GP000'.$postData['id'];
        $visitor_code_genrate = $year.' '.$month.' '.$day.' 000'.$postData['id'];
        
        $dataArray = array(
                    'name'  => $name,
                    'visitor_nric'  => $nric,
                    'cell_number'  => $cell_number,
                    // 'car_model'  => $car_model,
                    // 'car_number'  => $car_number,
                    // 'total_visitor'  => $total_visitor,
                    'mycard_image'  => $mycard_image,
                    'visitor_code'  => $visitor_code_genrate,
                    'login_status'  => 1,
                );
        $record = $user_obj->updateVisitorProfile($dataArray,$id);
        $data = $user_obj->getVisitorProfile($id);
        if($record){
             return response()->json(['response'=>'1','visitor_code'=>$visitor_code_genrate,'data'=>$data]);
        }    
        
        return response()->json(['response'=>'0']);
    }
    public function profileImageGet(Request $request)
    {
        $user_obj = new User;
        $postData = $request->all();
       
        $id = $postData['id'];
        $data = $user_obj->getVisitorProfile($id);
        if($data){
             return response()->json(['response'=>'1','image'=>$data->image]);
        }    
        
        return response()->json(['response'=>'0']);
    }

    public function getAboutUsOrTerms(Request $request){
        $user_obj = new User;
        $postData = $request->all();

        $page_key = $postData['page_key'];
        $data = $user_obj->getAboutUsOrTerms($page_key);
        if($data){
             return response()->json(['response'=>'1','data'=>$data]);
        }    
        
        return response()->json(['response'=>'0']);
    }

    public function checkusernumber(Request $request){
        $postData = $request->all();
        $errors = array();

        if(empty($postData['mobile_number'])) $errors[] = "mobile_number";
        if(empty($postData['type'])) $errors[] = "type ";    
        if(empty($postData['country_code'])) $errors[] = "country_code ";    

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

        $user_obj = new User;
        $Login_obj = new Login;

        $data = $user_obj->checkusernumber($postData);

        if(count($data) > 0){
            $six_digit_random_number = mt_rand(100000, 999999);
            $update = $Login_obj->setTemanOTP($data->nric, $postData['mobile_number'], $postData['type'], $six_digit_random_number, $postData['country_code']);

            $message = 'Your OTP for mobile number verification on the ICares mobile application is '.$six_digit_random_number;
            $Push_obj = new Push;
            
            //$push = $Push_obj->sendOtp($postData['mobile_number'], $message);

            $push = $Push_obj->sendVisitorOtp($postData['mobile_number'], $postData['country_code'], $message);
            if ($push == 1) {
                return response()->json(['response'=>true, 'data'=> $data]);
            } else{
                return response()->json(['response'=>false,
                    'message' =>  'OTP not send successfully'
                ]);
            }
        }
        
        return response()->json(['response'=>false,
            'message' =>  'Number not exist'
        ]);
    }

    public function checkuserotp(Request $request){
        
        $postData = $request->all();
        $errors = array();

        if(empty($postData['mobile_number'])) $errors[] = "mobile_number";
        if(empty($postData['type'])) $errors[] = "type ";    
        if(empty($postData['nric'])) $errors[] = "nric ";    
        if(empty($postData['otp'])) $errors[] = "otp ";    

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

        $user_obj = new User;

        $data = $user_obj->checkuserotp($postData);
        
        if(count($data) > 0){
             return response()->json(['response'=> true]);
        }    
        
        return response()->json(['response'=>false , 'message'=>'Please enter corrct OTP']);
    }

    public function getAllCounting(Request $request){
        
        $postData = $request->all();
        $errors = array();

        if(empty($postData['cell_number'])) $errors[] = "cell_number";
        if(empty($postData['property_id'])) $errors[] = "property_id ";    
        if(empty($postData['user_id'])) $errors[] = "user_id ";    
        if(empty($postData['unit_id'])) $errors[] = "unit_id     ";    
        if(empty($postData['ptd_id'])) $errors[] = "ptd_id     ";    

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
        $Invitation = new Invitation();
        $ptd_id = $postData['ptd_id'];
        $unit_id = $postData['unit_id'];
        $property_id = $postData['property_id'];
        
        $maintenance = $admin_obj->getUserMaintenanceFeesByDb($ptd_id, $unit_id, $property_id);

        $notice = $admin_obj->getNoticeByPtdId($ptd_id, $property_id);

        $invitation = $Invitation->residnetTodayVisitor($postData['user_id'], $postData['property_id'], $postData['unit_id']);

        $pass = $Invitation->residentTodaysPass($postData['user_id']);

        return response()->json(['response'=> true, 'maintenance' => count($maintenance), 'notice' => count($notice), 'invitation' => count($invitation), 'pass' => count($pass)]);
        
        //return response()->json(['response'=>false , 'message'=>'Please enter corrct OTP']);
    }
    
}
