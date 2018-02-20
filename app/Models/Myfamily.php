<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Myfamily extends Model
{
	public function get_family($ptd_id,$user_id,$unit_id, $property_id){
        
        return DB::table('my-family')->where('user_id',$user_id)->where('property_id',$property_id)->where('unit_id',$unit_id)->get();
    }
    public function save_image($dataArray){
        
        return DB::table('my-family')->insertGetId($dataArray);
    }
    public function delete_image($id){
        
        return DB::table('my-family')->where('id', $id)->delete();
    }
    public function getFamilyById($id){
        
        return DB::table('my-family')->where('id',$id)->first();
    }
    public function updateMyfamily($dataArray,$id){
        
        return DB::table('my-family')
            ->where('id', $id)
            ->update($dataArray);
    }
    
    
}
