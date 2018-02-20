<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Security;
use App\Models\Push;
use App\Models\Property;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Hash;
use DB;
use Session;
use Validator;
use Input;
use App\Requestors;
use File;
use PDF;

class VisitorController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    
    public function index() {         
    }


    /*Invite by resident*/
    public function residentVisitorInvite(Request $request){
        $postData = $request->all();

        $errors = array();

        if(empty($postData['mobile_number'])) $errors[] = "mobile_number";
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
        if(empty($postData['property_id'])) $errors[] = "property_id";
        if(empty($postData['property_unit_id'])) $errors[] = "property_unit_id";        
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

        $is_resident = false;
        $invite_visitor = array();
        $visitor_user_id = 0;
        $Invitation = new Invitation();
        $invite_resident = $Invitation->getUserIdBYMobileNumber($postData['mobile_number'], $postData['country_code']);       

        if(!empty($invite_resident)){
            $is_resident = true;
        }

        if(!$is_resident){
            $invite_visitor = $Invitation->getVisitorIdBYMobileNumber($postData['mobile_number'], $postData['country_code']);
            if(!empty($invite_visitor)){
                  $visitor_user_id = $invite_visitor->id;
            }else{
                $setdata = array('cell_number' => $postData['mobile_number'],
                                'name' =>'',
                                'visitor_nric' => '',
                                'profile_image' =>'',
                                'visitor_code' => date("yyddmm"),
                                'country_code' => $postData['country_code'],
                                'login_status' => 0
                                );
                $visitor_user_id = $Invitation->setVisitor($setdata);
            }            
        }else{
            $invite_visitor = $Invitation->getVisitorIdBYMobileNumber($postData['mobile_number'], $postData['country_code']);
            if(empty($invite_visitor)){
                $setdata = array('cell_number' => $invite_resident->mobile_number,
                                'name' => $invite_resident->name,
                                'visitor_nric' => $invite_resident->nric,
                                'profile_image' => $invite_resident->image,
                                'visitor_code' => date("yyddmm"),
                                'login_status' => 1,
                                'country_code' => $postData['country_code'],
                                'user_id' => $invite_resident->id
                                );
                 $visitor_user_id = $Invitation->setVisitor($setdata);
            }else{
                $visitor_user_id = $invite_visitor->id;
            }
        }

        $checkTodayReadySend = $Invitation->checkTodayReadySend($postData['resident_user_id'], $visitor_user_id);
        if($checkTodayReadySend){
            return response()->json(['response' => false , 
                'message' =>  "You have already sent invitation to this mobile number!"          
            ]);
        }

        $passCount = $Invitation->passCount();
        $visting_code = date("ydm").'00'.$passCount+1;
                /* visitor card*/
        $set_card = array('resident_user_id' => $postData['resident_user_id'], 
                              "visitor_user_id" => $visitor_user_id,
                              "sender_id" => $postData['resident_user_id'],
                              "send_by" => 1,
                              "visitor_mobile_number" => $postData['mobile_number'],
                              "property_id" =>  $postData['property_id'],
                              "property_unit_id" =>  $postData['property_unit_id'],
                              "visting_code" => $visting_code,
                                "created_at" => date("Y-m-d G:i:s"),
                                "visiting_date" => date("Y-m-d G:i:s"),
                                "updated_at" => date("Y-m-d G:i:s")
                            );
        $visitor_pass_id = $Invitation->setVisitorCard($set_card);

        /* Push notifications */
            $Message = array('title' => "Invitation",
                "text" => "Invitation on Icare",
                "customers" => $postData['mobile_number']);

            $Push_Model = new Push;
            $test = $Push_Model->send($Message);
            
            /* Push notification end */

        return response()->json(['response' => true , 
            'message' => 'Invitation sent successfully !',
            'mobile_number' => $postData['mobile_number'],
            'is_resident' => $is_resident,        
            'invite_visitor' => $invite_visitor,
            'visitor_pass_id' => $visitor_pass_id
        ]);
    }



        /*Invite by visitor*/
    public function visitorInviteResident(Request $request){
        $postData = $request->all();
        $errors = array();

        if(empty($postData['mobile_number'])) $errors[] = "mobile_number";
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
        if(empty($postData['property_id'])) $errors[] = "property_id";
        if(empty($postData['property_unit_id'])) $errors[] = "property_unit_id";
        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id";
        if(empty($postData['visitor_mobile_number'])) $errors[] = "visitor_mobile_number";        
        if(empty($postData['car_number'])) $errors[] = "car_number";        
        if(empty($postData['total_vistior'])) $errors[] = "total_vistior";        

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
       $checkTodayReadySend = $Invitation->checkTodayReadySend($postData['resident_user_id'], $postData['visitor_user_id']);
        if($checkTodayReadySend){
            return response()->json(['response' => false , 
                'message' =>  "You have already sent invitation to this mobile number!"          
            ]);
        }

        $passCount = $Invitation->passCount();
        $visting_code = date("ydm").'00'.$passCount+1;
                /* visitor card*/
        $set_card = array('resident_user_id' => $postData['resident_user_id'], 
                              "visitor_user_id" => $postData['visitor_user_id'],
                              "sender_id" => $postData['visitor_user_id'],
                              "send_by" => 2,
                              "visitor_mobile_number" => $postData['visitor_mobile_number'],
                              "property_id" =>  $postData['property_id'],
                              "property_unit_id" =>  $postData['property_unit_id'],
                              "car_number" =>  $postData['car_number'],
                              "total_vistior" =>  $postData['total_vistior'],
                              "visting_code" => $visting_code,
                              "created_at" => date("Y-m-d G:i:s"),
                              "visiting_date" => date("Y-m-d G:i:s"),
                              "updated_at" => date("Y-m-d G:i:s")
                            );
        $visitor_pass_id = $Invitation->setVisitorCard($set_card);

        return response()->json(['response' => true , 
            'message' => 'Invitation sent successfully !',
            'mobile_number' => $postData['mobile_number'] ,          
            'visitor_pass_id' => $visitor_pass_id
        ]);
    }


/* resident today visitor*/
    public function residnetTodayVisitor(Request $request){
        $postData = $request->all();

        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
        if(empty($postData['property_id'])) $errors[] = "property_id";
        if(empty($postData['property_unit_id'])) $errors[] = "property_unit_id";            

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
        $results = $Invitation->residnetTodayVisitor($postData['resident_user_id'], $postData['property_id'], $postData['property_unit_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

      /* visitor today visit*/
    public function visitorTodayVisits(Request $request){
        $postData = $request->all();

        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id ";
     
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
        $results = $Invitation->visitorTodayVisits($postData['visitor_user_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

    /* resident pending visitor*/
    public function residentPendingInvitation(Request $request){
        $postData = $request->all();

        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
        if(empty($postData['property_id'])) $errors[] = "property_id";
        if(empty($postData['property_unit_id'])) $errors[] = "property_unit_id";            

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
        $results = $Invitation->residentPendingInvitation($postData['resident_user_id'], $postData['property_id'], $postData['property_unit_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

     /* resident pending visitor*/
    public function residentAllInvite(Request $request){
        $postData = $request->all();

        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
        if(empty($postData['property_id'])) $errors[] = "property_id";
        if(empty($postData['property_unit_id'])) $errors[] = "property_unit_id";            

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
        $results = $Invitation->residentAllInvite($postData['resident_user_id'], $postData['property_id'], $postData['property_unit_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

 /* resident pending visitor*/
    public function visitorPendingInvitation(Request $request){
        $postData = $request->all();

        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id ";            

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
        $results = $Invitation->visitorPendingInvitation($postData['visitor_user_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

/* resident pending visitor*/
    public function visitorAllInvite(Request $request){
        $postData = $request->all();

        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id ";            

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
        $results = $Invitation->visitorAllInvite($postData['visitor_user_id']);

        return response()->json(['response' => true , 
            'data' => $results            
        ]);
    }

/* full card */
    public function visitingCard(Request $request){
        $postData = $request->all();
        if(empty($postData['visitor_card_id'])) $errors[] = "visitor_card_id ";
        //if(empty($postData['security_id'])) $errors[] = "security_id ";
      
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
        // $check = $Invitation->cardCheck($postData['visitor_card_id'], $postData['security_id']);

        // if ($check == 1) {
            $results = $Invitation->visitingCard($postData['visitor_card_id']);

            return response()->json(['response' => true , 
                'data' => $results            
            ]);
        // }  else {
        //     return response()->json(['response' => false , 
        //         'message' => 'This card is not available for your property.'            
        //     ]);
        // }
    }

    public function securityVisitingCard(Request $request){
        $postData = $request->all();
        if(empty($postData['visitor_card_id'])) $errors[] = "visitor_card_id ";
        if(empty($postData['security_id'])) $errors[] = "security_id ";
      
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
        $check = $Invitation->cardCheck($postData['visitor_card_id'], $postData['security_id']);
       
        if ($check == 1) {
            $results = $Invitation->securityvisitingCard($postData['visitor_card_id']);

            return response()->json(['response' => true , 
                'data' => $results            
            ]);
        }  else {
            return response()->json(['response' => false , 
                'message' => 'This card is not available for your property.'            
            ]);
        }
    }

    /* update visting status */
    public function updateVisitingStatus(Request $request){
        $postData = $request->all();
        
        if(empty($postData['visitor_card_id'])) $errors[] = "visitor_card_id ";
        if(empty($postData['new_status'])) $errors[] = "new_status ";
        // if(empty($postData['car_number'])) $errors[] = "car_number ";
        // if(empty($postData['total_visitor'])) $errors[] = "total_visitor ";
      
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
        $results = $Invitation->updateVisitingStatus($postData);

        return response()->json(['response' => true ,
            'message' => 'Updated visiting status successfully!',
            'data' => $results            
        ]);
    }

     /*  resident Update Favourite Status */
    public function residentUpdateFavouriteStatus(Request $request){
        $postData = $request->all();
        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id";
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id";
        if(empty($postData['new_status'])) $errors[] = "new_status ";
      
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
        $results = $Invitation->residentUpdateFavouriteStatus($postData);

        return response()->json(['response' => true ,
            'message' => 'Updated Favourite status successfully!',
            'data' => $results            
        ]);
    }

      /*  visitor Update Favourite Status */
    public function visitorUpdateFavouriteStatus(Request $request){
        $postData = $request->all();
        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id";
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id";
        if(empty($postData['new_status'])) $errors[] = "new_status ";
      
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
        $results = $Invitation->visitorUpdateFavouriteStatus($postData);

        return response()->json(['response' => true ,
            'message' => 'Updated Favourite status successfully!',
            'data' => $results            
        ]);
    }


/*resident favourite*/
    public function residentRecentFavourite(Request $request){
        $postData = $request->all();
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
      
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
        $favourite = $Invitation->residentFavourite($postData['resident_user_id']);
        $recent = $Invitation->residentRecent($postData['resident_user_id']);

        return response()->json(['response' => true , 
            'recent' => $recent,
            'favourite' => $favourite           
        ]);
    }

    /*visitor favourite*/
    public function visitorRecentFavourite(Request $request){
        $postData = $request->all();
        if(empty($postData['visitor_user_id'])) $errors[] = "visitor_user_id ";
      
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
        $favourite = $Invitation->visitorFavourite($postData['visitor_user_id']);
        $recent = $Invitation->visitorRecent($postData['visitor_user_id']);

        return response()->json(['response' => true , 
            'recent' => $recent,
            'favourite' => $favourite           
        ]);
    }

           /*visitor favourite*/
    public function getMobileCountryCode(Request $request){
        $postData = $request->all();
        if(empty($postData['mobile_number'])) $errors[] = "mobile_number ";
      
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

        $Push = new Push();
        $code = $Push->getMobileCountryCode($postData['mobile_number']);

        $messageStatus = $Push->sendOtp($postData['mobile_number'],'Send Message');
      
        return response()->json(['response' => true , 
            'code' => $code, 'message' => $messageStatus            
        ]);
   }


    public function getResidentTodaysPasses(Request $request){
        $postData = $request->all();
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
      
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
        $data = $Invitation->residentTodaysPass($postData['resident_user_id']);
        
        if (count($data) > 0) {
           return response()->json(['response' => true , 
                'pass' => $data        
            ]);
        }
        return response()->json(['response' => false 
        ]);
    }

    public function getResidentPasses(Request $request){
        $postData = $request->all();
        if(empty($postData['resident_user_id'])) $errors[] = "resident_user_id ";
      
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
        $data = $Invitation->residentPass($postData['resident_user_id']);
        
        if (count($data) > 0) {
           return response()->json(['response' => true , 
                'pass' => $data        
            ]);
        }
        return response()->json(['response' => false 
        ]);
    }

    public function checkRequest(Request $request){
        $postData = $request->all();

        if(empty($postData['mobile_number'])) $errors[] = "mobile_number ";
        if(empty($postData['visitor_id'])) $errors[] = "visitor_id ";
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

        $Invitation = new Invitation();
        $invite_resident = $Invitation->getUserIdBYMobileNumber($postData['mobile_number'], $postData['country_code']); 

        if ($invite_resident) {
            $check = $Invitation->checkVisitorRequest($invite_resident->id, $postData['visitor_id']);

            if (count($check) > 0) {
               return response()->json(['response' => true , 
                    'message' => "You have already sent request to this mobile number!"        
                ]);
            }
            return response()->json(['response' => false 
            ]);   
        } else {
            return response()->json(['response' => true , 
                    'message' => "Resident or tenant was not available!"        
                ]);
        }
    }
    

}
