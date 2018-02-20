<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Twilio;
use Nexmo;


class MessageController extends Controller
{
    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return 'message';
    }
    public function getMessageByUserId(Request $request)
    {
        $message_obj = new Message;
        $postData = $request->all();
        $user_id = $postData['user_id'];
        $record = $message_obj->getMessageByUserId($user_id);
        //print_r($record);die();
        if($record){
             return response()->json(['response'=>'1','data'=>$record]);
        } 
        return response()->json(['response'=>'0']);
    }
    public function deleteMessageById(Request $request)
    {
        $message_obj = new Message;
        $postData = $request->all();
        $id = $postData['id'];
        $delete = $message_obj->deleteMessageById($id);
        //print_r($record);die();
        if($delete){
             return response()->json(['response'=>'1']);
        } 
        return response()->json(['response'=>'0']);
    }
    public function ChangeMessageStatusById(Request $request)
    {
        $message_obj = new Message;
        $postData = $request->all();
        $id = $postData['id'];
        $status = $postData['status'];
        $change = $message_obj->ChangeMessageStatusById($id,$status);
        //print_r($record);die();
        if($change){
             return response()->json(['response'=>'1']);
        } 
        return response()->json(['response'=>'0']);
    }
    
}
