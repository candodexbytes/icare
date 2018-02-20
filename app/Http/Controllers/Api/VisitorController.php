<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Invitation;
use App\Models\Admin;
use App\Models\Property;
use App\Models\Otp;
use App\Models\Push;
use Twilio;
use Nexmo;

class VisitorController extends Controller{
    
    public function index(Request $request ){
    	$token = base64_encode('send-invitation');
        echo $token;die();
       
    	return response()->json(['response'=>'1']);
    }

	public function store(Request $request){
       //echo 'asd';die();
    	$Visitor_obj = new Visitor;
        $Property_obj = new Property;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        $reciever_cell_number = $postData['reciever_cell_number'] ;
        $sender_cell_number = $postData['sender_cell_number'] ;
        $ptd_id = $postData['ptd_id'] ;
        $sender_id = $postData['sender_id'] ;
        $unit_id = $postData['unit_id'] ;
        $property_id = $postData['property_id'] ;
        
        if($token == 'send-invitation'){

            $sender_data = $Visitor_obj->getResidentById($sender_id);
            $sender_name = $sender_data->name;

            $check = $Visitor_obj->checkVisitor($reciever_cell_number,$sender_id);
           
            $checkFriend = $Visitor_obj->checkFriend($reciever_cell_number, $sender_id, $sender_cell_number);
            if(count($check) > 0){
                return response()->json(['response'=>'2']);
            }else{
                if($checkFriend == 1){
                    $saveFriend = $Visitor_obj->saveFriendInvitation($reciever_cell_number, $sender_cell_number, $sender_id, '2', null);
                } 
                // else {
                //     $updateInviteStatus = $Visitor_obj->updateInviteStatus($reciever_cell_number, '0');
                // }
                $save = $Visitor_obj->saveInvitation($reciever_cell_number,$ptd_id,$sender_id,$unit_id, $property_id);

                $subject = 'You have invited by '.$sender_name;

                $Message = array('title' => "Invitation",
                    "text" => $subject,
                    "customers" => $reciever_cell_number);

                $Push_Model = new Push;
                $Push_Model->send($Message);

                return response()->json(['response'=>'1']);
            }
            
        }
        
    	return response()->json(['response'=>'0']);
    }
    /*public function otpGenrateVisitor(Request $request)
    {
        $Otp_obj = new Otp;
        $postData = $request->all();
        $token = base64_decode($postData['token']);
        
        $cell_number = $postData['cell_number'] ;
        
        if($token == 'otp-genrate'){
         
            $six_digit_random_number = substr($cell_number, -4);
            $message ='Your Condo Management Login OTP is: '.$six_digit_random_number.'';
            
            $save_array = array(
                                'cell_number'  => $cell_number,
                                'otp'    => $six_digit_random_number,
                                'otp_create_date'     => date("Y-m-d h:i:sa")
                                );   
            $save = $Otp_obj->save_Visitorotp($save_array);
            if($save == 2){
              return  response()->json(['response'=>'2']);
            }else{

               
                return  response()->json(['response'=>'1']);    
            }
            
        }
        
        return response()->json(['response'=>'0']);
    }*/
    
    public function getVisitorById(Request $request){ 
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $id = $postData['id'] ;
       
            $data = $Visitor_obj->getVisitorById($id);

            if(count($data) > 0){
                
                return response()->json(['response'=>'1','data'=>$data['0']]);
            }else{
                return response()->json(['response'=>'2']);
            }
       
        return response()->json(['response'=>'0']);
    }
    
    public function acceptRequestById(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $id = $postData['id'] ;
        $invite_status = $postData['invite_status'] ;
        $reciever_cell_number = $postData['reciever_cell_number'] ;
        $sender_cell_number = $postData['sender_cell_number'] ;
        $car_number = $postData['car_number'] ;
        $total_visitor = $postData['total_visitor'] ;
       
        $data = $Visitor_obj->acceptRequestById($id, $invite_status, $reciever_cell_number, $sender_cell_number, $car_number, $total_visitor);
        if($data){
            
            return response()->json(['response'=>'1']);
        }
       
        return response()->json(['response'=>'0']);
    }
    
    public function rejectRequestById(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $id = $postData['id'] ;
        $invite_status = $postData['invite_status'] ;
        $reciever_cell_number = $postData['reciever_cell_number'] ;
        $sender_cell_number = $postData['sender_cell_number'] ;
       
            $data = $Visitor_obj->rejectRequestById($id, $invite_status, $reciever_cell_number, $sender_cell_number);
            
            if($data){
                
                return response()->json(['response'=>'1']);
            }
       
        return response()->json(['response'=>'0']);
    }
    
    public function getVisitorList(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $sender_id = $postData['user_id'] ;
        $unit_id = $postData['unit_id'] ;
       
        $data = $Visitor_obj->getVistorListById($sender_id, $unit_id);
        
        if(count($data) > 0){
            return response()->json(['response'=>'1','data'=>$data]);
        }
       
        return response()->json(['response'=>'0']);
    }
    
    public function getAllInvitation(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $cell_number = $postData['cell_number'] ;
       
            $data = $Visitor_obj->getAllInvitation($cell_number);
            
            if(count($data) > 0){
                
                return response()->json(['response'=>'1','data'=>$data]);
            }
       
        return response()->json(['response'=>'0']);
    }

    public function getAllPasses(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $cell_number = $postData['cell_number'] ;
        $visitor_id = $postData['visitor_id'] ;
       
        $data = $Visitor_obj->getAllPasses($visitor_id, $cell_number);
        if(count($data) > 0){
            return response()->json(['response'=>'1','data'=>$data]);
        }
       
        return response()->json(['response'=>'0']);
    }
    
    public function getAllSendInvitation(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
       
        $visitor_id = $postData['visitor_id'] ;
       
            $data = $Visitor_obj->getAllSendInvitation($visitor_id);
            
            if(count($data) > 0){
                
                return response()->json(['response'=>'1','data'=>$data]);
            }
       
        return response()->json(['response'=>'0']);
    }
    
    public function getVisitorByCellNumber(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $cell_number = $postData['cell_number'] ;
       
        $data = $Visitor_obj->getVisitorByCellNumber($cell_number);
        if(count($data) > 0){
            
            return response()->json(['response'=>'1','data'=>$data[0]]);
        }
       
        return response()->json(['response'=>'0']);
    }
    
    public function favouriteVisitorStatusChange(Request $request){
       
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $user_id = $postData['user_id'] ;
        $status = $postData['status'] ;
        $reciever_cell_number =$postData['reciever_cell_number'];
        $sender_cell_number =$postData['sender_cell_number'];
        $sender_type =$postData['sender_type'];

        $data = $Visitor_obj->favouriteVisitorStatusChange($user_id,$status,$reciever_cell_number,$sender_cell_number,$sender_type);
        
            if($data){
                return response()->json(['response'=>'1']);
            }
       
        return response()->json(['response'=>'0']);
    }

    public function requestInvitationByVisitor(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $reciever_cell_number = $postData['reciever_cell_number'] ;
        $sender_cell_number = $postData['sender_cell_number'] ;
        $type = $postData['type'] ;
        $sender_id = $postData['sender_id'] ;
        $car_number = $postData['car_number'] ;
        $total_visitor = $postData['total_visitor'] ;
        $property_id = $postData['property_id'] ;
        $unit_id = $postData['unit_id'] ;

        $sender_data = $Visitor_obj->getVisitorById($sender_id);
        $data1 = json_decode($sender_data);
        $sender_name = $data1[0]->name;
        
        $visite_date = '2017-11-27 02:56:09';
        $check = $Visitor_obj->checkResident($reciever_cell_number);
        $checkFriend = $Visitor_obj->checkVisitorFriend($reciever_cell_number,$sender_id,$sender_cell_number);

        if (count($check) > 0) {
            $save_array = array('sender_id'   => $sender_id, 
                                'reciever_id' => $check->id,
                                'cell_number' => $reciever_cell_number,
                                'visiting_date' => $visite_date,
                                'sender_type' => $type,
                                'car_number' => $car_number,
                                'total_visitor' => $total_visitor,
                                'property_id' => $property_id,
                                'unit_id' => $unit_id
                                );

            if ($checkFriend == 1) {
                $saveFriend = $Visitor_obj->saveFriendInvitation($reciever_cell_number,$sender_cell_number,$sender_id,'3', $check->id);
            }

            $save = $Visitor_obj->sendInvitationByVisitor($save_array);

            $subject = 'You have requested by '.$sender_name;

            $Message = array('title' => "Invitation",
                "text" => $subject,
                "customers" => $reciever_cell_number);

            // $Push_Model = new Push;
            // $Push_Model->send($Message);

            return response()->json(['response'=>'1']);
        } else {
            return response()->json(['response'=>'0', 'message' => 'Resident Not Exist']); 
        } 
    }

    public function getVisitorAllRequest(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $type = $postData['type'] ;
        $sender_id = $postData['sender_id'];

        if ($sender_id && $type) {
            $data = $Visitor_obj->getAllVisitorRequest($type, $sender_id);
            return response()->json(['response'=>'1' , 'data' => $data]);
        } else {
            return response()->json(['response'=>'0']);
        }
    }

    public function getResidentAllRequest(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        
        $type = $postData['type'] ;
        $id = $postData['id'];
        $property_id = $postData['property_id'];
        $unit_id = $postData['unit_id'];

        if ($id && $type) {
            $data = $Visitor_obj->getAllResidentRequest($type, $id, $property_id, $unit_id);
            if (count($data) > 0) {
                return response()->json(['response'=>'1' , 'data' => $data]);    
            }
            return response()->json(['response'=>'0']);
        } else {
            return response()->json(['response'=>'0']);
        }
        
    }

    public function getResidentRequestDetail(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $id = $postData['id'];
        $request_id = $postData['request_id'];

        $data = $Visitor_obj->getResidentRequestDetail($id, $request_id);
        if (count($data) > 0) {
            return response()->json(['response'=>'1' , 'data' => $data]);    
        }
        return response()->json(['response'=>'0']);
        
        
    }
    
    // public function sendInvitationByVisitor(Request $request){
    //    //echo 'asd';die();
    //     $Visitor_obj = new Visitor;
    //     $postData = $request->all();
        
    //     $sender_id = $postData['sender_id'] ;
    //     $reciever_id = $postData['reciever_id'] ;
    //     $cell_number = $postData['cell_number'] ;
    //     $visite_date = $postData['date'] ;

    //         $check = $Visitor_obj->checkVisitor($cell_number,$sender_id);
            
    //         if(count($check) > 0){
                
    //             return response()->json(['response'=>'2']);
    //         }else{

    //             $save_array = array(
    //                             'sender_id'  => $sender_id,
    //                             'reciever_id'    => $reciever_id,
    //                             'cell_number'    => $cell_number,
    //                             'visite_date'     => $visite_date
    //                             ); 
    //             $save = $Visitor_obj->sendInvitationByVisitor($save_array);
    //             return response()->json(['response'=>'1']);
    //         }
            
        
        
    //     return response()->json(['response'=>'0']);
    // }

    public function checkoutInvite(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $id = $postData['id'] ;
        $status = $postData['type'] ;
        $cell_number = $postData['cell_number'] ;

        $data = $Visitor_obj->checkoutInvite($id,$status,$cell_number);
        if($data){
            return response()->json(['response'=>'1']);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function getResidentRecentInvites(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $user_id = $postData['user_id'];
        $sender_cell_number = $postData['sender_cell_number'];
        $data = $Visitor_obj->getResidentRecentInvites($user_id, $sender_cell_number);

        if($data){
            return response()->json(['response'=>'1' , 'visitor' => $data]);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function getVisitorRecentRequest(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $visitor_id = $postData['visitor_id'];
        $sender_cell_number = $postData['sender_cell_number'];
        $data = $Visitor_obj->getVisitorRecentRequest($visitor_id, $sender_cell_number);
        if($data){
            return response()->json(['response'=>'1' , 'visitor' => $data]);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function getResidentFavouriteInvites(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $user_id = $postData['user_id'];
        $sender_cell_number = $postData['sender_cell_number'];

        $data = $Visitor_obj->getResidentFavouriteInvites($user_id, $sender_cell_number);

        if($data){
            return response()->json(['response'=>'1' , 'visitor' => $data]);
        }
       
        return response()->json(['response'=>'0']);
    }
    
    public function getVisitorFavouriteRequest(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $visitor_id = $postData['visitor_id'];
        $sender_cell_number = $postData['sender_cell_number'];
        
        $data = $Visitor_obj->getVisitorFavouriteRequest($visitor_id, $sender_cell_number);
        if($data){
            return response()->json(['response'=>'1' , 'data' => $data]);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function updateVisitorProfile(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $id = $postData['id'];
        $name = $postData['name'];
        $visitor_nric = $postData['visitor_nric'];
        $cell_number = $postData['cell_number'];
        // $car_model = $postData['car_model'];
        // $car_number = $postData['car_number'];
        $mycard_image = $postData['mycard_image'];
        // $total_visitor = $postData['total_visitor'];

        $data = $Visitor_obj->updatevisitorprofile($id, $name, $visitor_nric, $cell_number, $mycard_image);
        if($data){
            return response()->json(['response'=>'1']);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function getVisitorDetailByNumber(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();
        $cell_number = $postData['cell_number'];
        $id = $postData['id'];

        $data = $Visitor_obj->visitordetailbynumber($cell_number, $id);
        if($data){
            return response()->json(['response'=>'1', 'data' => $data['0']]);
        }
       
        return response()->json(['response'=>'0']);
    }

    public function checkNumber(Request $request){
        $Visitor_obj = new Visitor;
        $invitation_obj = new Invitation;
        $postData = $request->all();

        if(empty($postData['cell_number'])) $errors[] = "cell_number";     
        if(empty($postData['country_code'])) $errors[] = "country_code";     

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

        $cell_number = $postData['cell_number'];
        $country_code = $postData['country_code'];

        $user = $invitation_obj->getUserIdBYMobileNumber($cell_number, $country_code);
        $visitor = $invitation_obj->getVisitorIdBYMobileNumber($cell_number, $country_code);
        
        if (count($user) > 0) {
            return response()->json(['response'=>false , 'message' => 'You have already registered as Resident, please login as Resident to accept invitation or request invitation']);
        } else if (count($visitor) > 0) {
            return response()->json(['response'=>false , 'message' => 'You have already registered as Visitor, please login as Visitor to accept invitation or request invitation']);
        }

       
        return response()->json(['response'=>true]);
    }

    public function checkNRIC(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        if(empty($postData['nric'])) $errors[] = "nric";      

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

        $nric = $postData['nric'];


        $user = $Visitor_obj->getUserIdBYNRIC($nric);
        $visitor = $Visitor_obj->getUserIdBYVisitor($nric);

        if (count($user) > 0) {
            return response()->json(['response'=>false , 'message' => 'You have already registered as Resident, please login as Resident to accept invitation or request invitation']);
        } else if (count($visitor) > 0) {
            return response()->json(['response'=>false , 'message' => 'You have already registered as Visitor, please login as Visitor to accept invitation or request invitation']);
        }

        return response()->json(['response'=>true]);
    }

    public function visitorSignup(Request $request){
        $Visitor_obj = new Visitor;
        $postData = $request->all();

        $six_digit_random_number = mt_rand(100000, 999999);
        $message = 'Your six digit OTP for mobile number verification on the ICares mobile application is '.$six_digit_random_number.'';
        $Push_Model = new Push;
        $pushData = $Push_Model->sendVisitorOtp($postData['cell_number'], $postData['country_code'], $message);
        
        if ($pushData == 1) {
            $save_array = array('name'   => $postData['name'], 
                            'visitor_nric' => $postData['visitor_nric'],
                            'cell_number' => $postData['cell_number'],
                            // 'car_model' => $postData['car_model'],
                            // 'car_number' => $postData['car_number'],
                            'country_code' => $postData['country_code'],
                            'mycard_image' => $postData['imageName'],
                            'login_status' => 1,
                            'otp' => $six_digit_random_number,
                            'otp_create_date'     => date("Y-m-d h:i:sa")
                        );

       
            $data = $Visitor_obj->visitorSignup($save_array);
            if($data == 1){
                return response()->json(['response'=>'1']);
            }
        } else {
            return response()->json(['response'=>'2']);;
        }
        
        return response()->json(['response'=>'0']);
    }

    public function walkinVisitor(Request $request){
        $postData = $request->all();
        
        if(empty($postData['property_id'])) $errors[] = "property_id ";
        if(empty($postData['unit_id'])) $errors[] = "unit_id ";
        if(empty($postData['country_code'])) $errors[] = "country_code ";
        if(empty($postData['name'])) $errors[] = "name ";
        if(empty($postData['nric'])) $errors[] = "nric ";
        if(empty($postData['cell_number'])) $errors[] = "cell_number ";
      
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

        $Invitation = new Invitation();
        $admin_obj = new Admin();

        $checkUserAvailable = $Invitation->checkUserInUnit($postData['property_id'],$postData['unit_id'],$postData['nric'], $postData['cell_number']);
        
        if (count($checkUserAvailable) == 0) {
            $unit_user=$admin_obj->getUnitUser($postData['property_id'],$postData['unit_id']);
        
            $checkVisitor = $Invitation->checkVisitorAvailable($postData['nric'], $postData['cell_number']);

            if ($checkVisitor['response'] == 1) {
                $setdata = array(   'cell_number' => $postData['cell_number'],
                                'name' =>$postData['name'],
                                'visitor_nric' => $postData['nric'],
                                'profile_image' =>'',
                                'visitor_code' => date("yyddmm"),
                                'country_code' => $postData['country_code'],
                                'login_status' => 1
                                );
                $visitor_user_id = $Invitation->setVisitor($setdata);

                $passCount = $Invitation->passCount();
                $visiting_code = date("ydm").'00'.$passCount+1;
               
                $set_card = array(  "resident_user_id" => $unit_user[0]->user_id,
                                    "visitor_user_id" => $visitor_user_id,
                                    "sender_id" => $unit_user[0]->user_id,
                                    "send_by" => 1,
                                    "visitor_mobile_number" => $postData['cell_number'],
                                    "property_id" =>  $postData['property_id'],
                                    "property_unit_id" =>  $postData['unit_id'],
                                    "visting_code" => $visiting_code,
                                    "created_at" => date("Y-m-d G:i:s"),
                                    "visiting_date" => date("Y-m-d G:i:s"),
                                    "updated_at" => date("Y-m-d G:i:s"),
                                    "invite_status" => 3
                                );
                $visitor_pass_id = $Invitation->setVisitorCard($set_card);
                if ($visitor_pass_id) {
                    return response()->json(['response' => true , 
                            'message' => "Resigter Successfully!"        
                        ]);
                }
            } else if ($checkVisitor['response'] == 2) {
                $passCount = $Invitation->passCount();
                $visiting_code = date("ydm").'00'.$passCount+1;
               
                $set_card = array(  "visitor_user_id" => $checkVisitor['id'],
                                    "send_by" => 2,
                                    "visitor_mobile_number" => $postData['cell_number'],
                                    "property_id" =>  $postData['property_id'],
                                    "property_unit_id" =>  $postData['unit_id'],
                                    "visting_code" => $visiting_code,
                                    "created_at" => date("Y-m-d G:i:s"),
                                    "visiting_date" => date("Y-m-d G:i:s"),
                                    "updated_at" => date("Y-m-d G:i:s"),
                                    "invite_status" => 3
                                );
                $visitor_pass_id = $Invitation->setVisitorCard($set_card);
                if ($visitor_pass_id) {
                    return response()->json(['response' => true , 
                            'message' => "Resigter Successfully!"        
                        ]);
                }
            }else if ($checkVisitor['response'] == 3) {
                return response()->json(['response' => false , 
                        'message' => "NRIC number aleady exit"        
                    ]);
            } else if ($checkVisitor['response'] == 4) {
                return response()->json(['response' => false , 
                        'message' => "Mobile number aleady exit"        
                    ]);
            }
        } else {
            return response()->json(['response' => false , 
                'message' =>  'You are already member of this unit'              
            ]);
        }
    }


    public function setVisitorPassword(Request $request){
        $postData = $request->all();

        if(empty($postData['visitor_id'])) $errors[] = "visitor_id ";
        if(empty($postData['password'])) $errors[] = "password ";

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

        $Visitor_obj = new Visitor;
        $setPassword = $Visitor_obj->setVisitorPassword($postData['visitor_id'], md5($postData['password']));

        if ($setPassword) {
            return response()->json(['response' => true , 
                'message' =>  'Password Save Successfully'              
            ]);
        }

        return response()->json(['response' => false             
            ]);

    }

    public function checkVisitorPassword(Request $request){
        $postData = $request->all();

        if(empty($postData['visitor_id'])) $errors[] = "visitor_id ";
        if(empty($postData['password'])) $errors[] = "password ";

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

        $Visitor_obj = new Visitor;

        $checkPassword = $Visitor_obj->checkVisitorPassword($postData['visitor_id'], md5($postData['password']));

        if (count($checkPassword) > 0) {
            return response()->json(['response' => true              
            ]);
        }

        return response()->json(['response' => false             
            ]);

    }

    // public function getVisitorPassDetail(Request $request){
    //     $Visitor_obj = new Visitor;
    //     $postData = $request->all();

    //     $id = $postData['id'];
    //     $cell_number = $postData['cell_number'];
    //     $sender_id = $postData['sender_id'];
    //     $invitation_status = $postData['invitation_status'];

    //     $data = $Visitor_obj->getPassDetail($id, $cell_number, $sender_id, $invitation_status);
    //     if($data == 0){
    //         return response()->json(['response'=>'1']);
    //     }
       
    //     return response()->json(['response'=>'0']);
    // }
}
