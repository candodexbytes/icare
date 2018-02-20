<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Invitation extends Model
{

	public function getUserIdBYMobileNumber($mobileNumber, $country_phone_code   ){   
	      return DB::table('users')
             ->where('mobile_number', $mobileNumber)
	       ->where('country_phone_code', $country_phone_code)
	       ->whereBetween('users.type', [1, 2])
	       ->select('*')->first();
	}


	public function getVisitorIdBYMobileNumber($mobileNumber, $country_code){  
	      return DB::table('visitors')
             ->where('cell_number', $mobileNumber)          
	       ->where('country_code', $country_code)	      
	       ->select('*')->first();
	}


	public function setVisitorCard($data){   
	      return DB::table('visiting_card')->insertGetId($data);
	}

	public function setVisitor($data){   
	      return DB::table('visitors')->insertGetId($data);
	}


	public function passCount(){   
	      return DB::table('visiting_card')->get()->count();
	}


	public function checkTodayReadySend($resident_user_id, $visitor_user_id){   
	      return DB::table('visiting_card')
       			// ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
       			// ->where('created_at', '<=', date('Y-m-d').' 23:59:59')
       			->where('invite_status','!=',  2)
       			->where('invite_status', '!=', 4)
       			->where('resident_user_id', $resident_user_id)
       			->where('visitor_user_id', $visitor_user_id)       			
       			->get()->count();
	}


	public function residnetTodayVisitor($resident_user_id, $property_id, $property_unit_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
       			// ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
       			// ->where('created_at', '<=', date('Y-m-d').' 23:59:59')
       			->where('invite_status','!=', 3)
       			->where('invite_status', '!=', 2)
       			->where('invite_status', '!=', 4)
       			->where('resident_user_id', $resident_user_id)
       			->where('property_id', $property_id)
       			->where('property_unit_id', $property_unit_id)
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status']);
	}


    public function visitorTodayVisits($visitor_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']]) 
       			// ->where('created_at', '>=', date('Y-m-d').' 00:00:00')
       			// ->where('created_at', '<=', date('Y-m-d').' 23:59:59')
       			->whereBetween('invite_status', [1,3])       		
       			->where('visitor_user_id', $visitor_user_id)       		
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.car_number','visiting_card.total_vistior','visiting_card.invite_status','users.name as resident_name' , 'users.mobile_number as resident_mobile','users.image as resident_image']);
	}



	public function visitorPendingInvitation($visitor_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])   
       			->where('visiting_card.created_at', '>=', date('Y-m-d'))       			
       			->where('visiting_card.invite_status','=', 0)       			
       			->where('visiting_card.visitor_user_id', $visitor_user_id)       			
       			->where('visiting_card.sender_id','!=', $visitor_user_id)
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status','users.name as resident_name' , 'users.mobile_number as resident_mobile','users.image as resident_image']);
	}


	public function residentPendingInvitation($resident_user_id, $property_id, $property_unit_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
       			->where('created_at', '>=', date('Y-m-d'))       			
       			->where('invite_status','=', 0)       			
       			->where('resident_user_id', $resident_user_id)
       			->where('property_id', $property_id)
       			->where('property_unit_id', $property_unit_id)
       			->where('sender_id','!=', $resident_user_id)
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status']);
	}

	public function visitorAllInvite($visitor_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])   
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])     					
       			->where('visitor_user_id', $visitor_user_id)       			
       			->where('sender_id', $visitor_user_id)
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status','users.name as resident_name' , 'users.mobile_number as resident_mobile','users.image as resident_image','users.id as resident_tenant_id']);
	}


	public function residentAllInvite($resident_user_id, $property_id, $property_unit_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])      			 		
                        //->where('invite_status','=', 0)       			
       			->where('resident_user_id', $resident_user_id)
       			->where('property_id', $property_id)
       			->where('property_unit_id', $property_unit_id)
       			->where('sender_id', $resident_user_id)
       			->orderBy('visiting_card.visiting_date', 'DESC')        			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status']);
	}


	public function visitingCard($visitor_card_id){   
            return DB::table('visiting_card')
                  ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])
                  ->Join('property_units',[['visiting_card.property_unit_id','=','property_units.id']])                  
                  ->where('visiting_card.id', $visitor_card_id)                                             
                  ->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
                        'visiting_card.total_vistior','visiting_card.favourite_resident','visiting_card.favourite_visitor','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','users.name as resident_name','users.mobile_number as resident_mobile','visiting_card.invite_status','property_units.address as unit_address' ,'property_units.block_number','property_units.unit_number'])->first();
      }

      public function securityvisitingCard($visitor_card_id){   
            return DB::table('visiting_card')
                  ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])                
                  ->where('visiting_card.id', $visitor_card_id)                                             
                  ->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
                        'visiting_card.total_vistior','visiting_card.favourite_resident','visiting_card.favourite_visitor','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visiting_card.invite_status'])->first();
      }


      public function cardCheck($visitor_card_id, $security_id){   
	      $getSecurity = DB::table('security_guard')
                        ->where('security_id', $security_id)
                        ->first();

            if (count($getSecurity) > 0) {
                  $getCard = DB::table('visiting_card')
                        ->where('property_id', $getSecurity->property_id)
                        ->where('id', $visitor_card_id)
                        ->first();

                  if (count($getCard) > 0) {
                        return true;
                  } else {
                        return false;
                  }
            } else {
                  return false;
            }
	}



	public function residentFavourite($resident_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])       	
       			->where('resident_user_id', $resident_user_id)
       			->where('favourite_resident', '=' , 1)    
       			->groupBy('visiting_card.visitor_user_id') 
       			->orderBy('visiting_card.visiting_date', 'DESC')    			      			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visitors.id as visitor_id','visitors.country_code as country_code']);
	}

	public function residentRecent($resident_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])       	
       			->where('resident_user_id', $resident_user_id)
       			//->where('favourite_resident', '!=', 1)    
       			->groupBy('visiting_card.visitor_user_id') 
       			->orderBy('visiting_card.visiting_date', 'DESC')    			      			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_resident','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','visitors.id as visitor_id','visitors.country_code as country_code']);
	}


	public function visitorFavourite($visitor_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']]) 
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])      	
       			->where('visitor_user_id', $visitor_user_id)
       			->where('favourite_visitor', '=' , 1)    
       			->groupBy('visiting_card.visitor_user_id') 
       			->orderBy('visiting_card.visiting_date', 'DESC')    			      			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_visitor','visitors.cell_number','users.country_phone_code as country_code','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','users.name as resident_name' , 'users.mobile_number as resident_mobile','users.image as resident_image','users.id as resident_id']);
	}

	public function visitorRecent($visitor_user_id){   
	      return DB::table('visiting_card')
	            ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])       
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])	
       			->where('visitor_user_id', $visitor_user_id)
       			//->where('favourite_visitor', '!=', 1)    
       			->groupBy('visiting_card.visitor_user_id') 
       			->orderBy('visiting_card.visiting_date', 'DESC')    			      			
       			->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
       				'visiting_card.total_vistior','visiting_card.favourite_visitor','visitors.cell_number','users.country_phone_code as country_code','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','users.name as resident_name' , 'users.mobile_number as resident_mobile','users.image as resident_image','users.id as resident_id']);
	}


	public function updateVisitingStatus($data) {
            return DB::table('visiting_card')
                        ->where('id', $data['visitor_card_id'])
                        ->update(['invite_status' => $data['new_status'],'car_number' => $data['car_number'], 'total_vistior' => $data['total_visitor']]);
     }


      public function residentUpdateFavouriteStatus($data) {
            return DB::table('visiting_card')
                        ->where('visitor_user_id', $data['visitor_user_id'])
                        ->where('resident_user_id', $data['resident_user_id'])
                        ->update(['favourite_resident' => $data['new_status']]);
      }

      public function visitorUpdateFavouriteStatus($data) {
            return DB::table('visiting_card')
                        ->where('visitor_user_id', $data['visitor_user_id'])
                        ->where('resident_user_id', $data['resident_user_id'])
                        ->update(['favourite_visitor' => $data['new_status']]);
      }



      public function visitingListByProperty($property_id){   
            return DB::table('visiting_card')
                  ->Join('visitors',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])
                  ->Join('property_units',[['visiting_card.property_unit_id','=','property_units.id']])                  
                  ->where('visiting_card.property_id', $property_id)                                             
                  ->get(['visiting_card.id as visiting_id','visiting_card.visiting_date','visiting_card.car_number',
                        'visiting_card.total_vistior','visiting_card.favourite_resident','visiting_card.favourite_visitor','visitors.cell_number','visitors.name','visitors.visitor_nric','visitors.profile_image','visitors.visitor_code','visitors.login_status','visitors.mycard_image','users.name as resident_name','users.mobile_number as resident_mobile','visiting_card.invite_status','property_units.address as unit_address' ,'property_units.block_number','property_units.unit_number']);
      }

      public function residentTodaysPass($user_id){   
            return DB::table('visitors')
                  ->Join('visiting_card',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])
                  ->where('visitors.user_id', $user_id)             
                  // ->where('visiting_card.invite_status', '1')   
                  ->whereBetween('visiting_card.invite_status', [0, 1])          
                  ->get(['visiting_card.property_id as property_id','visiting_card.id as visiting_card_id','visitors.id as visitor_id','visiting_card.invite_status as invite_status','visiting_card.property_unit_id as property_unit_id','users.id as sender_id','users.name as name','users.email as email','users.image as profile_image']);
      }

      public function residentPass($user_id){   
            return DB::table('visitors')
                  ->Join('visiting_card',[['visiting_card.visitor_user_id','=','visitors.id']])
                  ->Join('users',[['visiting_card.resident_user_id','=','users.id']])
                  ->where('visitors.user_id', $user_id)               
                  ->get(['visiting_card.property_id as property_id','visiting_card.id as visiting_card_id','visitors.id as visitor_id','visiting_card.invite_status as invite_status','visiting_card.property_unit_id as property_unit_id','users.id as sender_id','users.name as name','users.email as email','users.image as profile_image']);
      }

      public function checkVisitorRequest($user_id, $visitor_id){ 
            return DB::table('visiting_card')
                        ->where('visitor_user_id', $visitor_id)
                        ->where('resident_user_id', $user_id)
                        ->where('send_by', '2')
                        ->whereBetween('invite_status', [0, 2])
                        ->get(); 
      }


      public function checkVisitorAvailable($nric, $cell_number){
            $checkBoth = DB::table('visitors')->where('visitor_nric', $nric)->where('cell_number', $cell_number)->first();
            $checkNric = DB::table('visitors')->where('visitor_nric', $nric)->first();
            $checkNumber = DB::table('visitors')->where('cell_number', $cell_number)->first();

            if (count($checkBoth) > 0) {
                  return ['response' => 2 , 
                    'id' =>   $checkBoth->id,
                  ];
            } else if (count($checkNric) > 0) {
                  return ['response' => 3
                  ];
            } else if (count($checkNumber) > 0) {
                  return ['response' => 4
                  ];
            }

            return ['response' => 1
                  ];
      } 

      public function checkUserInUnit($property_id, $unit_id, $nric, $cell_number){
            return DB::table('users')
                  ->Join('unit_user_relation',[['users.id','=','unit_user_relation.user_id']])
                  ->where('unit_user_relation.property_id', $property_id)               
                  ->where('unit_user_relation.unit_id', $unit_id)               
                  ->where('users.nric', $nric)               
                  ->where('users.mobile_number', $cell_number)               
                  ->get(['users.*']);
      } 

 }
