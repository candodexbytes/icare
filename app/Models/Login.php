<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
    //
   

	protected $hidden=['id','medium_id'];

   
    public function login_check($data){
    	
        $check =  DB::table('users')->where('mobile_number',$data['mobile_number'])->where('password',$data['password'])->first(); 

        return $check;
    }
    
}
