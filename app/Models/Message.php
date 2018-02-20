<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Message extends Model
{
    
  public function getAllMessage(){
        
       return DB::table('message')->get();
  }
  public function getMessageInbox($id){
        
       return DB::table('message')->where('reciever_id',$id)->where('a_delete_status',0)->get();
  }
  public function getMessageSent($id){
        
       return DB::table('message')->where('sender_id',$id)->where('a_delete_status',0)->get();
  }
  public function get_user(){
        
       return DB::table('users')->whereBetween('type', [1, 2])->get();
  }
  public function saveMessageRecord($array){
        
        return DB::table('message')->insert($array);
  }
  public function getMessageByUserId($user_id){
        
       return DB::table('message')->where('u_delete_status',0)->where('sender_id',$user_id)->orWhere('reciever_id',$user_id)->orderBy('date', 'desc')->get();
  }
  public function deleteMessageById($id){
        
       return DB::table('message')->where('id',$id)->update(['u_delete_status'=>1]);
  }
  public function ChangeMessageStatusById($id,$status){
        
       return DB::table('message')->where('id',$id)->update(['status'=>$status]);
  }
  
    
}
