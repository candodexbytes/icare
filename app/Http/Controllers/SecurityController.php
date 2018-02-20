<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Security;
use App\Models\Push;
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

class SecurityController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //   $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
//        print_r(Session::get('visitor_property_data'));
        return view('security.index');
    }

    public function inVisitor($ptd_id = "") {
        if (!empty($ptd_id)) {
            $ptd_id = base64_decode($ptd_id);
            Session::put('visitor_ptd_id', $ptd_id);
            $security_obj = new Security;
            $ptd_id_genrate = str_replace('-', ' ', $ptd_id);
            $visitor_property = $security_obj->getproperty($ptd_id_genrate);
            Session::put('visitor_property_data', $visitor_property);
            return redirect('security');
        }
    }

    public function securityVisitor() {

        return view('security.security-visitor');
    }

    public function visitorList() {
        $property_id = '1';
        $ptd_id = $value = Session::get('visitor_ptd_id');
        $ptd_id_genrate = str_replace('-', ' ', $ptd_id);
        $date = date('Y-m-d');
        $security_obj = new Security;
        $visitor_data = $security_obj->get_visitor_user($ptd_id_genrate, $date, $property_id);
        return view('security.visitor-list', compact('visitor_data'));
    }

    public function visitorPass($id) {
        if ($id) {
            $security_obj = new Security;
            $visitors_info = $security_obj->get_visitor_info($id);
            
            return view('security.visitor-pass', compact('visitors_info'));
        }
    }

    public function registerPassbook() {
        return view('security.register-passbook');
//        $postData = $request->all();
//        
//        if(!empty($postData)){
//            print_r($postData);
//            die;
//            return redirect('security/pass-detail');    
//        }else{
//          return view('security.register-passbook');   
//        }
    }

    public function addpassbook(Request $request) {
        $postData = $request->all();




        if (!isset($request->car_file) && empty($request->car_file)) {
            $dataArray = array(
                'name' => $postData['name'],
                'visitor_nric' => $postData['nric'],
                'cell_number' => $postData['mobile'],
                'car_model' => $postData['car_model'],
                'car_number'=>$postData['car_number']
            );
        } else {
            $imageName = time() . '.' . $request->car_file->getClientOriginalExtension();
            $upload_image = $request->car_file->move(public_path('security-img'), $imageName);
            $dataArray = array(
                'name' => $postData['name'],
                'visitor_nric' => $postData['nric'],
                'cell_number' => $postData['mobile'],
                'car_model' => $postData['car_model'],
                 'car_number'=>$postData['car_number'],
                'mycard_image' => url('/') . '/public/security-img/' . $imageName
            );
        }

        $visitor_pass_array = array(
            'ptd_id' => str_replace('-', ' ', Session::get('visitor_ptd_id')),
            'sender_id' => '-1',
            'cell_number' => $dataArray['cell_number'],
            'invitation_status' => 1,
            'created_date' => date('Y-m-d'),
            'sender_type'=>2
        );

        $security_obj = new Security;
        $response_id = $security_obj->saveVisitor($dataArray, $visitor_pass_array);

        if ($response_id) {
            //return redirect('security/pass-detail/' . $response_id);
            return redirect('security/visitor-list/');
        }
    }

    public function detailPassbook($response_id = "") {
        if (!empty($response_id)) {
            $security_obj = new Security;
            $visitors_info = $security_obj->get_visitor_info($response_id);
            //print_r($visitors_info);
            return view('security.detail-passbook', compact('visitors_info'));
        }
    }

    public function changeSatus($visitor_pass_id = "") {
        if (!empty($visitor_pass_id)) {
            $security_obj = new Security;
            $update = $security_obj->update_status('visitor_pass', $visitor_pass_id, array('invitation_status' => 4));
            if ($update) {
                return response()->json(['response' => '1']);
            } else {

                return response()->json(['response' => '0']);
            }
        }
    }

}
