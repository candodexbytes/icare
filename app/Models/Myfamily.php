<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Myfamily extends Model
{
	public function get_family($ptd_id,$user_id){
        
        return DB::table('my_family')->where('user_id',$user_id)->where('ptd_id',$ptd_id)->get();
    }
    
    
}
