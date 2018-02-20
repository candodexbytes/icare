<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Email;
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

class EmailController extends Controller
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
        $email_obj = new Email;
        $data = $email_obj->getAllEmail();
        return view('admin.email',compact('data'));
    }
    public function EmailInbox()
    {
        $email_obj = new Email;
        $id = Auth::user()->id;
        $data = $email_obj->getEmailInbox($id);
        return view('admin.email-inbox',compact('data'));
    }
    public function EmailSent()
    {
        $email_obj = new Email;
        $id = Auth::user()->id;
        $data = $email_obj->getEmailSent($id);
        return view('admin.email-sent',compact('data'));
    }
    public function newEmail()
    {
        $email_obj = new Email;
        
        $id = Auth::user()->id;
        $email = Auth::user()->email;
        $get_user = $email_obj->get_user();
        
        return view('admin.new-email',compact('id','email','get_user'));
    }
    
    
}
