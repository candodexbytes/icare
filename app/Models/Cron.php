<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cron extends Model{

	public function getinviteCards(){   
	    return DB::table('visiting_card')
       			->where('invite_status', '!=', 4)     			
       			->get();
	}

	public function updateStatus($id, $status){   
	    return DB::table('visiting_card')
       			->where('id', $id)    			
       			->update(['invite_status' => $status]);
	}

}