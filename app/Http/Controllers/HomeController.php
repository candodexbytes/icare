<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function showLogin()
    {
        
        return View::make('login');
    }
    public static function test()
    {
    echo 'tester';
    }
    public function doLogin()
    {
    // process the form
    }
    public function CheckMobileNumber(Request $request)
    {   
        
        $postData    = $request->all();
        $admin_obj = new Admin;
        $user_obj = new User;

        
        $mobile_number = $postData['mobile_number'];
        $current_number = $postData['current_number'];
        
        $update_user = $admin_obj->CheckMobileNumber($mobile_number);

        if(count($update_user) > 0){
              if($current_number == $update_user->mobile_number){
                return 'true';
              }
              return 'false';

         }else{
             return 'true';
         }
    }
    
    
    
    
      public function CheckMobileNumberExist(Request $request)
    {   
        
        $postData    = $request->all();
        $admin_obj = new Admin; 
        $user_obj = new User;
         $cell_number = $postData['cell_number'];
        $exist_cell_number = $admin_obj->CheckMobileNumber($cell_number);

        if($exist_cell_number){
              return 'false';
         }else{
             return 'true';
         }
    }

    public function CheckNricNumber($ptd_id, $nric, $cell_number, $unit_id){  

        $admin_obj = new Admin;
        $user_obj = new User;

        //$exist_nric = $admin_obj->CheckNricNumber($ptd_id, $nric, $cell_number, $unit_id, '1');
        $exist_nric = $admin_obj->CheckNricNumberExist($ptd_id, $nric, $cell_number, $unit_id, '1');
        if ($exist_nric == 1) {
            return response()->json(['response' => '1']);
        } else if ($exist_nric == 2) {
            return response()->json(['response' => '2']);
        } else if ($exist_nric == 3) {
            return response()->json(['response' => '3']);
        } else {
            return response()->json(['response' => '0']);
        }
    }
}
