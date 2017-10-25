<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Otp extends Model
{
    //
   

	protected $hidden=['id','medium_id'];

   	public function save_otp($array){
   		$get_user = DB::table('users')->where('mobile_number', $array['mobile_number'])->first();
   		if(count($get_user) > 0){
   			$check =  DB::table('users')
	            ->where('id', $get_user->id)
	            ->update($array);
	        $return = 1;
	        return $return;
   		}else{
   			$return = 2;
   			return $return;
   		}
   		
        
    }
    public function veryfy_otp($verify_array){
   		$get_user = DB::table('users')->where('mobile_number', $verify_array['mobile_number'])->where('otp', $verify_array['otp'])->first();
   		if(count($get_user) > 0){
   			
	        return $get_user;
   		}else{
   			
   			return $get_user;
   		}
   		
        
    }
   
    
}
