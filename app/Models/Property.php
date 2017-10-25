<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Property extends Model
{
	public function get_property(){
        
        return DB::table('property')->get();
    }
    public function deleteproperty($id){
        
        return DB::table('property')->where('id',$id)->delete();
    }
    public function updateData($array,$id){
        
        return DB::table('property')
            ->where('id', $id)
            ->update($array);

    }
    
}
