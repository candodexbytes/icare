<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Register extends Model
{
    //
   

	protected $hidden=['id','medium_id'];

   public function register($register){
   
        return DB::table('users')->insertGetId($register);
    }
    public function mobile_check($mobile_number){
        $check =  DB::table('users')->where('mobile_number', $mobile_number)->first(); 

        return count($check);
    }
    public function nric_check($nric_check){
        $check =  DB::table('users')->where('nric', $nric_check)->first(); 

        return count($check);
    }
    
}
