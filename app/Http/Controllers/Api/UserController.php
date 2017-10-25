<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    
    public function index(Request $request )
    {
    	echo 'asd';die();
        
    	return response()->json(['response'=>'0']);
    }
	public function store(Request $request)
    {
    	$user_obj = new User;
        $data = $user_obj->get_user();
    	return response()->json(['response'=>'1','data'=>$data]);
    }
}
