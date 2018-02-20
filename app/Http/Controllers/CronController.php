<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Push;
use App\Models\Cron;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Hash;
use DB;

class CronController extends Controller {

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    
    public function index() {         
    }

    public function updateInviteStatus(){
    	$date = date('Y-m-d H:i:s');
    	$currentStamp = strtotime($date) - 86400;
    	
    	$cron = new Cron();
        $invite_status = $cron->getinviteCards(); 

        foreach ($invite_status as $key => $value) {
        $cardStamp = strtotime($value->created_at);

        	if ($cardStamp < $currentStamp) {
  				$invite_status = $cron->updateStatus($value->id ,'2');
        	}
        }
    }
}