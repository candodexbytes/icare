<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
	
    public function get_last(){
        
        return DB::table('property')->orderBy('id', 'desc')->take(1)->first();
    }
    public function saveData($array){
        
        return DB::table('property')->insert($array);
    }
    
}
