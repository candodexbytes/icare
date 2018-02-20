<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
    //
   

	protected $hidden=['id','medium_id'];

   
    public function login_check($data){	
        $check =  DB::table('users')->where('nric',$data['nric'])->where('type',$data['type'])->where('mobile_number',$data['mobile_number'])->where('password',$data['password'])->first(); 

        return $check;
    }

    public function nric_check($nric_number, $mobile_number, $type, $country_phone_code){

        $check =  DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->where('country_phone_code',$country_phone_code)->first();
        if (count($check) == 0) {
            return 3;
        } else {
            if ($check->status == 1) {
                $check1 =  DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->where('password','')->first();
                if (count($check1) == 1) {
                    return 1;
                } else {
                    return 0;
                }   
            } else {
                return 2;
            }
        }      
    }

    public function setTemanOTP($nric_number, $mobile_number, $type, $six_digit_random_number, $country_phone_code){	

    	$check =  DB::table('users')
	            ->where('mobile_number', $mobile_number)
	            ->where('nric', $nric_number)
                ->where('type', $type)
	            ->where('country_phone_code', $country_phone_code)
	            ->update(['otp' => $six_digit_random_number, 'otp_create_date' => date("Y-m-d h:i:sa")]);

        return $check;
    }

    public function temanLogin($nric_number, $mobile_number, $type, $password, $temanOTP){	
    	$check =  DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->where('password',$password)->first();
    	if (count($check) != 1) {
    	 	return DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->where('otp',$temanOTP)->first();
    	 }
        return $check;
    }

    public function setPassword($login_type, $password, $user_id){
        return  DB::table('users')
                ->where('id',$user_id)
                ->where('type',$login_type) 
                ->update(['password' => $password]);
    }

    public function check_resident_active($nric_number, $mobile_number, $type, $country_phone_code){
        $check =  DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->first();
        if (count($check) > 0) {
            $check1 =  DB::table('users')->where('nric',$nric_number)->where('type',$type)->where('mobile_number',$mobile_number)->where('status',1)->first();
            
            if (count($check1) == 0) {
                return 0;
            } else {
                return 1;
            }
        }

        return 1;
    }
    
}
