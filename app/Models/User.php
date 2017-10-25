<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
	public function get_user(){
        
        return DB::table('users')->where('type', '!=', 0)->get();
    }
    public function get_last(){
        
        return DB::table('property')->select('ptd_id')->orderBy('id')->take(1)->get();
    }
    
}
