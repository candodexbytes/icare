<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Insurance extends Model
{
	public function get_insurance($ptd_id,$user_id,$property_id){
        
        return DB::table('insurance')->where('user_id',$user_id)->where('property_id',$property_id)->first();
    }
    public function save_insurance($dataArray){
        
        return DB::table('insurance')->insertGetId($dataArray);
    }
    public function update_insurance($dataArray,$id){
        
        return DB::table('insurance')
            ->where('id', $id)
            ->update($dataArray);
    }

    public function delete_insurance($id){
        
        return DB::table('insurance')->where('id', $id)->delete();
    }
    
    
    
}
