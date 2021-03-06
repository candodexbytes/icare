<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Message;
use App\Models\Admin;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Hash;
use DB; 
use Session; 
use Validator; 
use Input;
use App\Requestors;
use File;
use PDF;
use Nexmo;
use App\Models\Push;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message_obj = new Message;
        $data = $message_obj->getAllMessage();
        return view('admin.message',compact('data'));
    }


    public function MessageInbox()
    {
        $message_obj = new Message;
        $id = Auth::user()->id;
        $data = $message_obj->getMessageInbox($id);
        return view('admin.message-inbox',compact('data'));
    }


    public function MessageSent()
    {
        $message_obj = new Message;
        $id = Auth::user()->id;
        $data = $message_obj->getMessageSent($id);
        return view('admin.message-sent',compact('data'));
    }



    public function newMessage()
    {
        $message_obj = new Message;
        $id = Auth::user()->id;
        $name = Auth::user()->name;
         
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $get_user = $admin_obj->getAllUsers($property_id);

        return view('admin.new-message',compact('id','name','get_user'));
    }



    public function sendMessageToUser(Request $request)
    {
        $message_obj = new Message;
        $postData = $request->all();
        $sender_id = Auth::user()->id;
        $from_name = Auth::user()->name;
        $message = 'Subject: '.$postData['subject'].'<br>'.$postData['message'];
        $mobile_string = '';
        if(isset($postData['sent_to'])){
            foreach ($postData['sent_to'] as $value) {
                $value_array = explode('__', $value);
                if($value_array[0] !== 'multiselect-all'){                     
                     $save_array = array(
                                'ptd_id'        => $this->getSessionId(),
                                'sent_to'       => $value_array[1],
                                'sent_from'     => $from_name,
                                'subject'       => $postData['subject'],
                                'message'       => $postData['message'],
                                'sender_id'     => $sender_id,
                                'reciever_id'   => $value_array[0],
                                );

                    if($value_array[2] != ''){
                            $mobile_string .= $value_array[2] . ';';
                    }
                    
                    $save = $message_obj->saveMessageRecord($save_array);  
                }                
            }

         
          /* Push notifications */
            $Message = array('title' => "Message",
                "text" => $postData['subject'],
                "customers" => $mobile_string);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            /* Push notification end */

            return back()->with('success','Message sent successfully.');
        }
        return back()->with('success','Message not sent successfully.');
    }



public function getSessionId(){
       if(isset(Session::get('Property')->id)){
         return Session::get('Property')->id;
       }else{
        return false;
       } 
  }

    
}

