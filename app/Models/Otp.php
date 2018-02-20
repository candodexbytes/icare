<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Otp extends Model
{
     
	  protected $hidden=['id','medium_id'];
   	public function save_otp($array){
   		$get_user = DB::table('visitors')->where('cell_number', $array['cell_number'])->where('country_code', $array['country_code'])->get(); 

   		if(count($get_user) > 0){
   			$check =  DB::table('visitors')
    	            ->where('cell_number', $array['cell_number'])
                  ->where('country_code', $array['country_code'])
    	            ->update($array);
        	         return 1;
   		}else{
   		         	return 2;
   		}
    }
    public function veryfy_otp($verify_array){
   		$get_user = DB::table('users')
                  ->where('mobile_number', $verify_array['mobile_number'])
                  ->where('otp', $verify_array['otp'])
                  ->first();
   		if(count($get_user) > 0){   			
	        return $get_user;
   		}else{
   		 	return $get_user;
   		}
    }


    public function save_Visitorotp($array){
      $get_user = DB::table('visitors')->where('cell_number', $array['cell_number'])->first();
      if(count($get_user) > 0){
        $check =  DB::table('visitors')
              ->where('id', $get_user->id)
              ->update($array);
          return 1;
      }
  }
  public function veryfyVisitorotp($verify_array){
      return DB::table('visitors')->where('cell_number', $verify_array['cell_number'])->where('otp', $verify_array['otp'])->where('country_code', $verify_array['country_code'])->first();  
  }

  public function checkVisitorNumber($cell_number){
    return DB::table('visitors')->where('cell_number', $cell_number)->get();
  }

}