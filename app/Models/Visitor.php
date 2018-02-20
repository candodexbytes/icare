<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Visitor extends Model
{


  public function getResidentById($id){   
       return DB::table('users')->where('id', $id)->first();
  }
    
  public function checkVisitor($cell_number,$sender_id){    
      // $query = DB::table('visitor_pass')->where('cell_number', $cell_number)->where('sender_id', $sender_id)->where('visiting_date', 'like', date('Y-m-d').'%')->get();

    $query = DB::table('visitor_pass')->where('cell_number', $cell_number)->where('sender_id', $sender_id)->get();
    return $query;
  }

  public function checkFriend($reciever_cell_number, $sender_id, $sender_cell_number){
    $query1 = DB::table('my_friends')->where('reciever_cell_number', $reciever_cell_number)->where('sender_cell_number', $sender_cell_number)->where('sender_type', '2')->get();

    // $query2 = DB::table('my_friends')->where('reciever_cell_number', $sender_cell_number)->where('sender_cell_number', $reciever_cell_number)->get();
    
    if (count($query1) == 0) {
      return 1;
    } else {
      return 0;
    }
  }

  public function checkVisitorFriend($reciever_cell_number, $sender_id, $sender_cell_number){
    $query1 = DB::table('my_friends')->where('reciever_cell_number', $reciever_cell_number)->where('sender_cell_number', $sender_cell_number)->where('sender_type', '3')->get();

    // $query2 = DB::table('my_friends')->where('reciever_cell_number', $sender_cell_number)->where('sender_cell_number', $reciever_cell_number)->get();
    
    if (count($query1) == 0) {
      return 1;
    } else {
      return 0;
    }
  }

  public function checkResident($cell_number){
       return DB::table('users')->where('mobile_number', $cell_number)->where('status', '1')->first();
  }

  public function saveInvitation($cell_number,$ptd_id,$sender_id, $unit_id, $property_id){
        $check = DB::table('visitors')->where('cell_number', $cell_number)->first();
        if(count($check) > 0){

        }else{
          $save = DB::table('visitors')->insert(['cell_number'=>$cell_number,'unit_id'=>$unit_id ]);
        }
       return DB::table('visitor_pass')->insert(['cell_number'=>$cell_number,'ptd_id'=>$ptd_id,'property_id'=>$property_id,'sender_id'=>$sender_id,'sender_type' => '2','unit_id'=>$unit_id]);
  }

  public function saveFriendInvitation($reciever_cell_number, $sender_cell_number,$sender_id, $sender_type, $reciever_id){
      return DB::table('my_friends')->insert(['reciever_cell_number'=>$reciever_cell_number,'sender_id'=>$sender_id,'sender_cell_number'=>$sender_cell_number,'sender_type' => $sender_type,'reciever_id'=>$reciever_id]);
  }

  public function updateInviteStatus($cell_number, $invitation_status){
       // return DB::table('my_friends')->insert(['cell_number'=>$cell_number,'sender_id'=>$sender_id,'sender_type' => $sender_type,'reciever_id'=>$reciever_id]);
    return DB::table('my_friends')->where('cell_number', $cell_number)->update(['invitation_status'=>$invitation_status]);
  }

  public function getVisitorById($id){   
       return DB::table('visitors')->where('id', $id)->get();
  }

  public function acceptRequestById($id, $invite_status, $reciever_cell_number, $sender_cell_number, $car_number, $total_visitor){
    $changeStatus = DB::table('my_friends')->where('reciever_cell_number', $sender_cell_number)->where('sender_cell_number', $reciever_cell_number)->update(['invitation_status'=>$invite_status]);
       return DB::table('visitor_pass')->where('id', $id)->update(['invitation_status'=>1 , 'car_number'=> $car_number, 'total_visitor'=> $total_visitor]);
  }

  public function rejectRequestById($id, $invite_status, $reciever_cell_number, $sender_cell_number){
        $changeStatus = DB::table('my_friends')->where('reciever_cell_number', $sender_cell_number)->where('sender_cell_number', $reciever_cell_number)->update(['invitation_status'=>$invite_status]);
       return DB::table('visitor_pass')->where('id', $id)->update(['invitation_status'=>3]);
  }

  public function getVistorListById($sender_id, $unit_id){  

    $query1 = DB::table('visitor_pass') 
            ->Join('visitors',[['visitors.cell_number','=','visitor_pass.cell_number']])
            ->where('visitor_pass.unit_id', $unit_id)
            ->where('visitor_pass.sender_id', $sender_id)
            ->select('visitor_pass.*','visitors.name','visitors.visitor_nric','visitors.mycard_image')
            ->get();
  return $query1;
    //return DB::table('visitor_pass')->where('sender_id', $sender_id)->where('unit_id', $unit_id)->where('sender_type', '2')->where('invitation_status', '0')->orWhere('invitation_status', '1')->orWhere('invitation_status', '4')->orderBy('created_date', 'desc')->get();
  }

  public function getAllVisitorRequest($type, $sender_id){     
      return DB::table('visitor_pass')->where('sender_id', $sender_id)->where('sender_type', $type)->orderBy('created_date', 'desc')->get();
  }

  public function getAllResidentRequest($type, $id, $property_id, $unit_id){  
        
    $query1 = DB::table('visitor_pass') 
            ->Join('visitors',[['visitors.id','=','visitor_pass.sender_id']])
            ->where('visitor_pass.sender_type', $type)
            ->where('visitor_pass.reciever_id', $id)
            ->where('visitor_pass.property_id', $property_id)
            ->where('visitor_pass.unit_id', $unit_id)
            ->select('visitor_pass.*','visitors.name','visitors.visitor_nric','visitors.mycard_image','visitors.cell_number')
            ->get();   
    return $query1;
      // return DB::table('visitor_pass')->where('reciever_id', $id)->where('sender_type', $type)->where('invitation_status', '0')->orderBy('created_date', 'desc')->get();
  }

  public function getResidentRequestDetail($id, $request_id){  
        
    $query1 = DB::table('visitor_pass') 
            ->Join('visitors',[['visitors.id','=','visitor_pass.sender_id']])
            ->where('visitor_pass.id', $request_id)
            ->where('visitor_pass.sender_id', $id)
            ->select('visitor_pass.*','visitors.name','visitors.visitor_nric','visitors.mycard_image','visitors.cell_number','visitors.visitor_code')
            ->first();   
    return $query1;
  }

  public function getAllInvitation($cell_number){     
       return DB::table('visitor_pass')->where('cell_number', $cell_number)->orderBy('created_date', 'desc')->get();
  }

  public function getAllPasses($visitor_id, $cell_number){   

  $array1 = []; 
        $query1 = DB::table('visitor_pass') 
            ->Join('users',[['users.id','=','visitor_pass.reciever_id']])
            ->where('visitor_pass.sender_id', $visitor_id)
            ->where('visitor_pass.sender_type', '3')
            ->select('visitor_pass.*','users.name','users.nric','users.image','users.mobile_number')
            ->get();  

        $i = 0;
        foreach ($query1 as $key => $value) {
          $array1[$i] = $value;
          $i++;
        } 

        $query2 = DB::table('visitor_pass') 
            ->Join('users',[['users.id','=','visitor_pass.sender_id']])
            ->where('visitor_pass.cell_number', $cell_number)
            ->where('visitor_pass.sender_type', '2')
            ->select('visitor_pass.*','users.name','users.nric','users.image','users.mobile_number')
            ->get();   

        foreach ($query2 as $key => $value) {
          $array1[$i] = $value;
          $i++;
        }
        
        return $array1;
      //return DB::table('visitor_pass')->where('cell_number', $cell_number)->orderBy('created_date', 'desc')->get();
  }

  public function getAllSendInvitation($visitor_id){
        
       return DB::table('visitor_pass')->where('sender_id', $visitor_id)->orderBy('created_date', 'desc')->get();
  }
  
 public function getVisitorByCellNumber($cell_number){
      return DB::table('visitors')->where('cell_number', $cell_number)->first();
  	}  

  public function favouriteVisitorStatusChange($user_id,$status,$reciever_cell_number,$sender_cell_number, $sender_type){
    if ($sender_type == 2) {
      return DB::table('my_friends')->where('reciever_cell_number', $reciever_cell_number)->where('sender_cell_number', $sender_cell_number)->update(['favourite_visitor'=>$status]);
    } else if ($sender_type == 3) {
      return DB::table('my_friends')->where('sender_cell_number', $reciever_cell_number)->where('reciever_cell_number', $sender_cell_number)->update(['favourite_visitor'=>$status]);
    }
      
       // return DB::table('visitor_pass')->where('cell_number', $cell_number)->update(['favourite_visitor'=>$status]);
  }

  public function sendInvitationByVisitor($save_array){
    return DB::table('visitor_pass')->insert($save_array);
  }

  public function checkoutInvite($id,$status,$cell_number){
    // $changeStatus = DB::table('my_friends')->where('cell_number', $cell_number)->update(['favourite_visitor'=>$status]);
    // return $changeStatus;
    return DB::table('visitor_pass')->where('id', $id)->update(['invitation_status'=>$status]);
  }

  public function getResidentRecentInvites($id, $sender_cell_number){
    // $query = DB::table('my_friends')->where('sender_id', $id)->orWhere('reciever_id', $id)->where('favourite_visitor', '0')->orderBy('created_date', 'desc')->get();
    $array1 = [];
    $query = DB::table('visitors') 
            ->Join('my_friends',[['my_friends.reciever_cell_number','=','visitors.cell_number']])
            ->where('my_friends.sender_id', $id)
            ->where('my_friends.favourite_visitor', '0')
            ->select('visitors.*','my_friends.sender_type')
            ->get();

    $i = 0;
    foreach ($query as $key => $value) {
      $array1[$i] = $value;
      $i++;
    }
           
  $query1 = DB::table('visitors') 
            ->Join('my_friends',[['my_friends.sender_cell_number','=','visitors.cell_number']])
            ->where('my_friends.reciever_id', $id)
            ->where('my_friends.favourite_visitor', '0')
            ->select('visitors.*','my_friends.sender_type')
            ->get();

  foreach ($query1 as $key => $value) {
      $array1[$i] = $value;
      $i++;
    }
    return $array1;
  }

  public function getVisitorRecentRequest($id, $sender_cell_number){

      $array1 = [];
      $query = DB::table('users') 
            ->Join('my_friends',[['my_friends.reciever_cell_number','=','users.mobile_number']])
            ->where('my_friends.sender_cell_number', $sender_cell_number)
            ->where('my_friends.favourite_visitor', '0')
            ->select('users.*','my_friends.sender_type')
            ->get();

        $i = 0;
        foreach ($query as $key => $value) {
          $array1[$i] = $value;
          $i++;
        }

        $query1 = DB::table('users') 
            ->Join('my_friends',[['my_friends.sender_cell_number','=','users.mobile_number']])
            ->where('my_friends.reciever_cell_number', $sender_cell_number)
            ->where('my_friends.favourite_visitor', '0')
            ->select('users.*','my_friends.sender_type')
            ->get();

        foreach ($query1 as $key => $value) {
          $array1[$i] = $value;
          $i++;
        }

    
        return $array1;
    // return DB::table('my_friends')->where('sender_id', $id)->where('favourite_visitor', '0')->where('sender_type', '3')->orderBy('created_date', 'desc')->get();
  }

  public function getResidentFavouriteInvites($id, $sender_cell_number){
    // return DB::table('my_friends')->where('sender_id', $id)->where('favourite_visitor', '1')->where('sender_type', '2')->orderBy('created_date', 'desc')->get();
    $array1 = [];
    $query = DB::table('visitors') 
            ->Join('my_friends',[['my_friends.reciever_cell_number','=','visitors.cell_number']])
            ->where('my_friends.sender_id', $id)
            ->where('my_friends.favourite_visitor', '1')
            ->select('visitors.*','my_friends.sender_type')
            ->get();

    $i = 0;
    foreach ($query as $key => $value) {
      $array1[$i] = $value;
      $i++;
    }
           
  $query1 = DB::table('visitors') 
            ->Join('my_friends',[['my_friends.sender_cell_number','=','visitors.cell_number']])
            ->where('my_friends.reciever_id', $id)
            ->where('my_friends.favourite_visitor', '1')
            ->select('visitors.*','my_friends.sender_type')
            ->get();

  foreach ($query1 as $key => $value) {
      $array1[$i] = $value;
      $i++;
    }
    return $array1;
  }

  public function getVisitorFavouriteRequest($id, $sender_cell_number){

      $array1 = [];
      $query = DB::table('users') 
            ->Join('my_friends',[['my_friends.reciever_cell_number','=','users.mobile_number']])
            ->where('my_friends.sender_cell_number', $sender_cell_number)
            ->where('my_friends.favourite_visitor', '1')
            ->select('users.*','my_friends.sender_type')
            ->get();

        $i = 0;
        foreach ($query as $key => $value) {
          $array1[$i] = $value;
          $i++;
        }

        $query1 = DB::table('users') 
            ->Join('my_friends',[['my_friends.sender_cell_number','=','users.mobile_number']])
            ->where('my_friends.reciever_cell_number', $sender_cell_number)
            ->where('my_friends.favourite_visitor', '1')
            ->select('users.*','my_friends.sender_type')
            ->get();

        foreach ($query1 as $key => $value) {
          $array1[$i] = $value;
          $i++;
        }

    
        return $array1;
    // return DB::table('my_friends')->where('sender_id', $id)->where('favourite_visitor', '1')->where('sender_type', '3')->orderBy('created_date', 'desc')->get();
  }

  public function updatevisitorprofile($id, $name, $visitor_nric, $cell_number, $mycard_image){
    return DB::table('visitors')->where('id', $id)->update(['visitor_nric'=>$visitor_nric, 'name'=>$name, 'visitor_nric'=>$visitor_nric, 'cell_number'=>$cell_number, 'mycard_image'=>$mycard_image]);
  }

  public function visitordetailbynumber($cell_number, $id){
    $query1 = DB::table('visitor_pass') 
            ->Join('visitors',[['visitors.cell_number','=','visitor_pass.cell_number']])
            ->where('visitor_pass.id', $id)
            ->select('visitor_pass.*','visitors.name','visitors.visitor_nric','visitors.mycard_image')
            ->get();
  return $query1;
    //return DB::table('visitors')->where('cell_number', $cell_number)->first();
  }

  public function checkNumber($cell_number){
    $check = DB::table('users')->where('mobile_number', $cell_number)->get();
    if (count($check) == 0) {
        $check1 = DB::table('visitors')->where('cell_number', $cell_number)->get();
        return count($check1);
     } else {
        return count($check);
     }
  }

  public function getUserIdBYNRIC($nric){
    $check = DB::table('users')->where('nric', $nric)->get();

    return $check;
  }

  public function getUserIdBYVisitor($nric){
    $check = DB::table('visitors')->where('visitor_nric', $nric)->get();

    return $check;
  }

  public function visitorSignup($save_array){
       $data = DB::table('visitors')->insertGetId($save_array);
       if ($data) {
        $day = date("d");
        $month = date("m");
        $year = date("y");

        $visitor_code_genrate = $year.' '.$month.' '.$day.' 000'.$data;
        return DB::table('visitors')->where('id', $data)->update(['visitor_code'=>$visitor_code_genrate]);
       }
  }


  public function setVisitorPassword($visitor_id, $password){
    return DB::table('visitors')->where('id', $visitor_id)->update(['password'=>$password]);
  }

  public function checkVisitorPassword($visitor_id, $password){
    return DB::table('visitors')->where('id', $visitor_id)->where('password',$password)->first();
  }

  // public function getPassDetail($id, $cell_number, $sender_id, $invitation_status){
  //     $query1 = DB::table('users') 
  //           ->Join('visitor_pass',['visitor_pass.cell_number','=','users.mobile_number'])
            
  //           ->select('users.*')
  //           ->get();

  //           print_r($query1);
  //           die;
  // }
  
}
