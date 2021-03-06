<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Push;
use App\Models\Property;
use App\Models\Billplz;
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
use App;
use Country;
use App\Models\Invitation;

class AdminController extends Controller {

    protected $billplzURL = 'https://billplz-staging.herokuapp.com/api/';
    /**
     * Create a new controller instance.
     *  
     * @return void
     */
    public function __construct() {
//        echo "hello";die;
        $this->middleware('auth');
        

                 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
      public function set() {
        $User = Auth::user(); 
         $userType = $User->type;
          $Admin = new Admin;
             $Property = new Property;
             $property_id = $User->property_id;
      
           $Property = $Property->getPropertyById($property_id);     

            Session::put('Property', $Property);
            if(!Session::has('Property')){
               Session::put('Property', $Property);
            }

        if ($userType != 0 ) {  
            if(empty($property_id)){
                return view('admin.unauthorized');    
            } 

          

           return redirect('/admin/manage-property');   
        }   
       
        return redirect('/taman-condo');  
    }
    
    public function index() {
      if(Auth::user()){
         $ptd_id = Auth::user()->ptd_id; 
        if(isset($ptd_id) && !empty($ptd_id)){
          $admin_obj = new Admin;
          $getProperty=  $admin_obj->getdata('property', 'ptd_id', $ptd_id, '*');
          if($getProperty){
           Session::put('property_data', $getProperty);
            $type = Auth::user()->type;
            $admin_obj = new Admin;
            $ptd_id = Auth::user()->ptd_id;
            $getpropertyid = $admin_obj->get_propertyid($ptd_id);
            $actualid = isset($getpropertyid->id) ? $getpropertyid->id : null;
           if ($type == 5 || $type == 6) {
            return redirect('/admin/manage-property/' . $actualid . '');
           }
	        if($type==0){
	           return redirect('/taman-condo');   
	        }
	          
        }else{
           return view('admin.unauthorized');   
         }
        }
      }
     }

    public function newDesign() {
          return view('admin.newdesign');
    }

     public function subAdmin() {
      $admin_obj = new Admin;
      $property_id = $this->getSessionId(); 
      $data = $admin_obj->get_subAdmin($property_id); 
      return view('admin.subadmin', compact( 'data'));
    }

  public function addSubAdminPage() {
        return view('admin.add-subadmin');
    }

    public function addNewUser() {
        $property_obj = new Property;
        $actualid = Auth::user()->taman_condo_id;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.add-newuser', compact('township_name'));
    }

     public function addUnit(){
              return view('admin.add-unit');
    }
    
 

     public function addUnitUser($property_id, $property_unit_id){
        $property_obj = new Property;
        $admin_obj = new Admin;
         if(isset(Session::get('Property')->township_name)){
           $township_name =  Session::get('Property')->township_name;
         }

        $unit_info  =  $admin_obj->getdata('property_units','id', $property_unit_id, '*');
        return view('admin.add-unit-user', compact('township_name','property_unit_id','unit_info', 'property_id'));
    }
    public function addNewResidentUser() {
        $property_obj = new Property;
        $actualid = Auth::user()->taman_condo_id;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.add-residentuser', compact('township_name'));
    }

    public function addNewTenantUser() {

        $property_obj = new Property;
        $actualid = Auth::user()->taman_condo_id;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.add-tenantuser', compact('township_name'));
    }

    public function deletesubAdmin($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deletesubAdmin($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function addNewSubAdmin(Request $request) {
        $admin_obj = new Admin;
        $postData = $request->all();
       
       $email_check = $admin_obj->emailCheckUser($postData['email']);
        if (count($email_check) > 0) {
            return back()->with('error', 'Email id already register to another account.')->with('id', '');
        }
        $mobile_check = $admin_obj->mobileCheckUser($postData['cell_number']);
        if (count($mobile_check) > 0) {
            return back()->with('error', 'Cell number already register to another account.')->with('id', '');
        }
        $dataArray = array(
            'name' => $postData['name'],
            'email' => $postData['email'],
            'ptd_id' => $this->getSessionPtdId(),
            'property_id'=>$this->getSessionId(),
            'mobile_number' => $postData['cell_number'],
            'taman_condo_id' =>  $this->getSessionId(),
            'password' => bcrypt($postData['password']),
            'type' => $postData['account_type'],
            'first_name' => $postData['name']
        );
        $save_user = $admin_obj->saveUserData($dataArray);
        if ($save_user) {
              Session::flash('success', 'User created successfully!'); 
              return redirect('/rcmc-admin'); 
            // return back()->with('success', 'RC/MC created successfully.')->with('id', '');
        } else {
            return back()->with('success', 'RC/MC not update please try again.')->with('id', '');
        }
    }
    
   

   public function saveNewUser(Request $request) {
        $admin_obj = new Admin;
        $postData = $request->all();
        $taman_condo_id = Auth::user()->taman_condo_id;
        $ptd_id = Auth::user()->ptd_id;
        $email_check = $admin_obj->emailCheckUser($email);
        if (count($email_check) > 0) {
            return back()->with('error', 'Email id already register to another account.')->with('id', '');
        }
        $mobile_check = $admin_obj->mobileCheckUser($cell_number);
        if (count($mobile_check) > 0) {
            return back()->with('error', 'Cell number already register to another account.')->with('id', '');
        }
        $dataArray = array(
            'name' => $postData['name'],
            'email' => $postData['email'],
            'ptd_id' => $this->getSessionPtdId(),
            'taman_condo_id' => $this->getSessionId(),
            'nric' => $postData['nric'],
            'mobile_number' => $postData['cell_number'],
            'address' => $postData['address'],
            'house_number' => $postData['house_number'],
            'block_number' => $postData['house_number'],
            'password' => bcrypt($postData['password']),
            'type' => $postData['account_type'],
            'first_name' => $postData['name'],
            'status' => 1
        );
        $save_user = $admin_obj->saveUserData($dataArray);
        if ($save_user) {
            return back()->with('success', 'User created successfully.')->with('id', '');
        } else {
            return back()->with('success', 'User not add please try again.')->with('id', '');
        }
    }
    
    public function saveNewUnitUser(Request $request) {
        $admin_obj = new Admin;
        $property_obj = new Property;
        $postData = $request->all(); 

        // if($postData['email'] != ''){
        //     $email_check = $admin_obj->emailCheckUser($postData['email']);
        //     if (isset($email_check)) {
        //       return back()->with('error', 'Email id already register to another account. Please Try another email id..')->with('id', '');
        //     }
        // }

        $name = $postData['name'];
        $nric = $postData['nric'];
        $email = $postData['email'];
        $cell_number = $postData['cell_number'];
        $property_unit_id  = $postData['unit_id'];
        $country_phone_code  = $postData['country_phone_code'];
       /* $password = md5($postData['password']);*/
        $account_type = $postData['account_type'];
        $ptd_id = $postData['ptd_id'];
        $user_id = $admin_obj->getIdByNricAndMobile($nric, $cell_number);
        $get_code = $property_obj->getPropertyById($this->getSessionId());

        if ($account_type == 1) {
            $taman_type = 'Resident';
        } else if ($account_type == 2) {
            $taman_type = 'tenant';
        }

        //$country_phone_code = $get_code->country_phone_code;

        if ($user_id) {  
              $unit_exist =  $admin_obj->checkUserUnitRelation($user_id , $this->getSessionId() , $property_unit_id); 
              if($unit_exist){
                  Session::flash('error', 'User is already register for this Units!'); 
                   return redirect('/admin/add-unit-user/'.$this->getSessionId().'/'.$property_unit_id);
              }   
        }else{    
            $dataArray = array(
                'name' => $name,
                'email' => $email,
                'ptd_id' => '0',
                'taman_condo_id' => '0',
                'nric' => $nric,
                'mobile_number' => $cell_number,
                'password' => '',
                'type' => $account_type,
                'first_name' => $name,
                'status' => 1,
                'country_phone_code' => $country_phone_code
            );

              $user_id = $admin_obj->insertData('users',$dataArray);
        }

        if ($user_id) {
           $unit_user_array = array(
                'user_id'=> $user_id,
                'property_id' => $this->getSessionId(),
                'unit_id' => $property_unit_id
            );

           $unit_user_data = $admin_obj->insertData('unit_user_relation',$unit_user_array); 
           
           // $message = 'You are added as a '.$taman_type.' in Icare property';
           $message = "You're invited by your community to join iCARES Community. Please click below link to download iCARES app.";
           $Push_Model = new Push;
           $push = $Push_Model->sendVisitorOtp($cell_number, $country_phone_code, $message);

           return response()->json(['response' => 1 
            ]);
           Session::flash('success', 'User created successfully.'); 
           return redirect('/admin/unit'); 
        } else {
            Session::flash('error', 'Something went wrong please try again!'); 
            return redirect('/admin/unit');           
        }
    }
    
      public function saveNewUnit(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;

        $url = $this->billplzURL.'v2/collections';
        $ch = curl_init($url);
    
        $fields = array(
            'title' => $postData['unit_ptd']. ' ' .$postData['block_number']. ' ' .$postData['house_number']. ' ' .$postData['address'],
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, "323d17f7-6fa7-45b0-92a1-ce6b39c0f4d5");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
        $result_array = json_decode($result);

        $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=> $this->getSessionId(),
                'unit_ptd' => $postData['unit_ptd'],
                'block_number' => $postData['block_number']!='' ? $postData['block_number'] : ' ' ,
                'unit_number' => $postData['house_number'],
                'address' => $postData['address'],
                'collection_id' => $result_array->id
               
        );
        $save_unit = $admin_obj->saveUnitData($dataArray);
        if ($save_unit) {
              Session::flash('success', 'New Unit created successfully!'); 
              return redirect('/admin/unit');        
        } else {
            return back()->with('error', 'New Unit not update please try again.')->with('id', '');
        }
     
    }


    public function saveNewSecurity(Request $request){
      $postData = $request->all();  
        $admin_obj = new Admin;
            $dataArray=array(
                'property_id'=>$this->getSessionId(),
                'security_name'=>$postData['security_name'],
                'username'=>$postData['user_name'],
                'password'=>md5($postData['password'])
                ); 
      $exist_result=$admin_obj->getWhere('security_guard',array('username'=>$postData['user_name']));
        if($exist_result){
     //Session::flash('error', 'This Username already Exist!'); 
     return back()->with('error', 'This Username already Exist!')->with('id', '');
     }else{
       $save_security = $admin_obj->insertData('security_guard',$dataArray);
        
        if ($save_security) {

              Session::flash('success', 'New security created successfully!'); 
              return redirect('/admin/security-link');        
        } else {
            return back()->with('error', 'New security not create please try again.')->with('id', '');
        }     
     }
      
    }

    public function UpdateResidentUser(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
      
        if (!empty($password)) {
            $dataArray = array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=> $this->getSessionId(),
                'nric' => $postData['nric'],
                'mobile_number' => $postData['cell_number'],
                'password' => bcrypt($postData['password']),
                'first_name' => $postData['name']
            );
        } else {
            $dataArray = array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=> $this->getSessionId(),
                'nric' => $postData['nric'],
                'mobile_number' => $postData['cell_number'],
                'first_name' => $postData['name']
            );
        }

        $update_resident = $admin_obj->updateResidentuser($dataArray, $id);


        if ($update_resident) {
              Session::flash('success', 'Resident User update successfully.'); 
              return redirect('/resident-user'); 
          
        } else {
            return back()->with('success', 'Resident User not update please try again.')->with('id', '');
        }
    }


    public function updateSecurity(Request $request){
    $postData = $request->all();
        $admin_obj = new Admin; 
          if (!empty($postData['password'])) {
            $updateArray=array(
              'security_name'=>$postData['security_name'],
              'username'=>$postData['user_name'],
              'password'=>bcrypt($postData['password'])
            );
          }else{
              $updateArray=array(
              'security_name'=>$postData['security_name'],
              'username'=>$postData['user_name']
             );
          }
             $exist_result=$admin_obj->getResultWhereNot($postData['security_id'],$postData['user_name']);
        if($exist_result){
            Session::flash('success', 'This Username already Exist,Enter Another Usename!'); 
              return redirect('/admin/security-link'); 
    
     }else{
  $update_security = $admin_obj->updateTableData('security_guard', $updateArray,array('security_id'=>$postData['security_id']));

    if ($update_security) {
              Session::flash('success', 'Security Updated successfully!'); 
              return redirect('/admin/security-link');        
        } else {
            return back()->with('error', 'security not Update please try again.')->with('id', '');
        }  
     }
          
    }
    public function UpdateTenantUser(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        if (!empty($postData['password'])) {
            $dataArray = array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'nric' => $postData['nric'],
                'mobile_number' => $postData['cell_number'],
                'password' => bcrypt($postData['password']),
                'first_name' => $postData['name']
            );
        } else {
            $dataArray = array(
                'name' => $postData['name'],
                'email' => $postData['email'],
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'nric' => $postData['nric'],
                'mobile_number' => $postData['cell_number'],
                'first_name' => $postData['name']
            );
        }
        $update_tenantuser = $admin_obj->updateResidentuser($dataArray, $id);
        if ($update_tenantuser) {
          
           if(isset($postData['user_type']) && $postData['user_type']=="tenant"){
            Session::flash('success', 'Tenant update successfully'); 
            return redirect('/tenant-user');      
           }else{
                Session::flash('success', 'User update successfully'); 
             return back()->with('success', 'User update successfully')->with('id', '');      
           }
             
            
        } else {
            return back()->with('success', 'Tenant User not update please try again.')->with('id', '');
        }
    }

    public function unitActionChange($id, $status) {
        $admin_obj = new Admin;
        $delete = $admin_obj->updateStatus('property_units',$id, $status);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }
   
    public function getAllUsers() {  
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $data = $admin_obj->getAllUnitUsers($property_id , 0);  
        $title = "All Resident/Tenant Users";
        return view('admin.allusers', compact('data','title'));
    }

      public function getResidentUsers() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $data = $admin_obj->getAllUnitUsers($property_id, 1);
        $title = "All Resident Users";
        return view('admin.allusers', compact('data','title'));
    }

     public function getTenantUsers() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $data = $admin_obj->getAllUnitUsers($property_id, 2); 
        $title = "All Tenant Users";
        return view('admin.allusers', compact('data','title'));
    }

    public function getAllProperty() {
        $property_obj = new Property;
        $type = Auth::user()->type;
        $admin_obj = new Admin;
        $Property = $property_obj->getPropertyById($this->getSessionId());           
        Session::put('property_data', $Property);
        if ($type == 5 || $type == 6) {            
             return redirect('/admin/manage-property/');   
        }

        if(Session::has('Property')){
               Session::forget('Property');
        } 
        $data = $property_obj->get_property();  
        $country = Country::$country;      
        return view('admin.property', compact('data','country'));
    }

     public function userlogin(){
       return redirect('/logout');   
    }
    
    public function addNewProperty() {
        $admin_obj = new Admin;
        $last_record = $admin_obj->get_last();

        if (empty($last_record)) {
            $ptd_id_genrate = 'PTD ' . date("m") . date("y") . '01';
        } else {
            $total = explode('PTD ', $last_record->ptd_id);
            $total_find = $total[1] + 1;
            $ptd_id_genrate = 'PTD ' . date("m") . date("y") . $total_find;
        }
        $country_array = Country::$country;
        return view('admin.property-add', compact('country_array'));
    }

    public function sendProperty(Request $request) {
        $postData = $request->all();

        $country_array = explode(',',$postData['country_name']);

        $this->validate($request, [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $admin_obj = new Admin;
        $billplz_obj = new Billplz;
        $last_record = $admin_obj->get_last();

        $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
        $upload_image = $request->image_file->move(public_path('images'), $imageName);
        if ($upload_image) {
            if (empty($last_record)) {
                $ptd_id_genrate = 'PTD ' . date("m") . date("y") . '01';
            } else {
                $total = explode('PTD ', $last_record->ptd_id);

                $total_find = $total[1] + 1;
                $ptd_id_genrate = 'PTD ' . $total_find;
            }

            $collection_id = $billplz_obj->create_collection();
            
            // $url = $this->billplzURL.'v4/mass_payment_instruction_collections';
            // $ch = curl_init($url);
        
            // $fields = array(
            //     'title' => $postData['township_name']. ' ' .$postData['country_name']. ' ' .$postData['state']. ' ' .$postData['city_name'],
            // );
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            // curl_setopt($ch, CURLOPT_USERPWD, "323d17f7-6fa7-45b0-92a1-ce6b39c0f4d5");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // //execute post
            // $result = curl_exec($ch);
            // $result_array = json_decode($result);

            $dataArray = array(
                'ptd_id' => $ptd_id_genrate,
                'country' => $country_array['0'],
                'country_code' => $country_array['1'],
                'country_phone_code' => $country_array['2'],
                'township_name' => $postData['township_name'],
                'zipcode' => $postData['zipcode'],
                'city_name' => $postData['city_name'],
                'state' => $postData['state'],
                'area_name' => $postData['area_name'],
                'property_type' => $postData['property_type'],
                'address' => $postData['address'],
                'property_management_contact' => $postData['property_management_contact'],
                'resident_committee_contact' => $postData['resident_committee_contact'],
                'collection_id' => $collection_id,
                'image' => url('/') . '/public/images/'.$imageName
            );
            $save_property = $admin_obj->saveData($dataArray);
             if($save_property){
                Session::flash('success', 'You have successfully added property.'); 
              return redirect('/taman-condo');   
            }else{
         return back()->with('success', 'error to add new property.');
            }
          
        }
        return back()
                        ->with('success', 'error to add new property.')
                        ->with('image', '');
        //return view('admin.property-add');
    }

    public function deleteProperty($id) {
        $property_obj = new Property;
        $delete = $property_obj->deleteproperty($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function updateProperty(Request $request) {
        $postData = $request->all();
		    $country_array = explode(',',$postData['country_name']);
        $property_obj = new Property;
        $id = $postData['id'];
        if (isset($postData['image_file'])) {
            $image_set = $postData['image_file'];
        } else {
            $image_set = '';
        }
        if (empty($image_set)) {

            $dataArray = array(
                'country' => $country_array['0'],
                'country_code' => $country_array['1'],
                'country_phone_code' => $country_array['2'],
                'township_name' => $postData['township_name'],
                'zipcode' => $postData['zipcode'],
                'state' => $postData['state'],
                'city_name' => $postData['city_name'],
                'area_name' => $postData['area_name'],
                'property_type' => $postData['property_type'],
                'address' => $postData['address'],
                'property_management_contact' => $postData['property_management_contact'],
                'resident_committee_contact' => $postData['resident_committee_contact'],
            );
        } else {
            $this->validate($request, [
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();

            $upload_image = $request->image_file->move(public_path('images'), $imageName);
            if ($upload_image) {
                $dataArray = array(
                    'country' => $country_array['0'],
                	'country_code' => $country_array['1'],
               		'country_phone_code' => $country_array['2'],
                    'township_name' => $postData['township_name'],
                    'zipcode' => $postData['zipcode'],
                    'state' => $postData['state'],
                    'city_name' => $postData['city_name'],
                    'area_name' => $postData['area_name'],
                    'property_type' => $postData['property_type'],
                    'address' => $postData['address'],
                    'property_management_contact' => $postData['property_management_contact'],
                    'resident_committee_contact' => $postData['resident_committee_contact'],
                    'image' => url('/') . '/public/images/' . $imageName
                );
            } else {
                $dataArray = array(
                   'country' => $country_array['0'],
                	'country_code' => $country_array['1'],
               	    'country_phone_code' => $country_array['2'],
                    'township_name' => $postData['township_name'],
                    'zipcode' => $postData['zipcode'],
                    'state' => $postData['state'],
                    'city_name' => $postData['city_name'],
                    'area_name' => $postData['area_name'],
                    'property_type' => $postData['property_type'],
                    'address' => $postData['address'],
                    'property_management_contact' => $postData['property_management_contact'],
                    'resident_committee_contact' => $postData['resident_committee_contact'],
                );
            }
        }
        $update_property = $property_obj->updateData($dataArray, $id);
        if ($update_property) {
            return back()->with('success', 'Property updated successfully')->with('image', '');
        } else {
            return back()->with('success', 'You have error in image file.')->with('image', '');
        }
        return back()->with('success', 'Something wrong!')->with('image', '');
    }

    public function emergancyContactIndex() {
        $admin_obj = new Admin;
          $property_id = $this->getSessionId();
        $get_record = $admin_obj->get_emergencyContact($property_id);
        return view('admin.emergancy-contact', compact('get_record'));
    }

  public function addNoticeIndex() {
            return view('admin.notice-add');
    }

    public function addContactIndex() {
        return view('admin.emergancy-contact-add');
    }

    public function addSecurity(){
          return view('admin.add-security');
    }

    public function addHandymanContactIndex() {
        $admin_obj = new Admin;
        $coupon_type = $admin_obj->getEcouponType();
        return view('admin.handyman-contact-add', compact('coupon_type'));
    }

    public function AllUserIndex($id) {
        $admin_obj = new Admin;
        $user_obj = new User;

        $data = $user_obj->get_user();
        $ptd_id_genrate = str_replace('-', ' ', $id);
        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $actualid = $getpropertyid->id;
        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.property-all-user', compact('township_name', 'ptd_id_genrate', 'id', 'data', 'actualid'));
    }

    public function getMyFamilyByUserID($id, $user_id) {

        $admin_obj = new Admin;
        $user_obj = new User;

        $ptd_id_genrate = str_replace('-', ' ', $id);
        $data = $admin_obj->getMyFamily($ptd_id_genrate, $user_id);
        $family_member = $admin_obj->getFamilyMember($ptd_id_genrate, $user_id);

        $tenant_details = $admin_obj->getTenantDetails($ptd_id_genrate, $user_id);
        $car_details = $admin_obj->getCarDetails($ptd_id_genrate, $user_id);
        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $actualid = $getpropertyid->id;
        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.property-myfamily', compact('township_name', 'ptd_id_genrate', 'id', 'data', 'family_member', 'tenant_details', 'car_details'));
    }

   public function getMyFamilyData($user_id, $unit_id) {
      //  $user_id
        $admin_obj = new Admin;
        $family_member = $admin_obj->getFamilyMember($user_id, $unit_id);
        $tenant_details = $admin_obj->getTenantDetails($user_id, $unit_id);
        $car_details = $admin_obj->getCarDetails($user_id, $unit_id);
        return view('admin.my-family-data', compact('family_member', 'tenant_details', 'car_details'));
    }
    
     public function getMyUnitUserData($property_id, $unit_id) {
       
        $admin_obj = new Admin;
        $propery_id = $this->getSessionId();
        $unit_user=$admin_obj->getUnitUser($propery_id,$unit_id);
        $unit_id =  $unit_id;
        return view('admin.unit-user-data', compact('unit_user','unit_id'));
  }
    
  public function getUserUnit($unit_id, $user_id) {
        $admin_obj = new Admin;
        $user_units=$admin_obj->getUserUnits($unit_id,$user_id);
        $user_id=$user_id;
        $unit_id=$unit_id;
       return view('admin.user-units', compact('user_units','user_id','unit_id'));
  } 
  
  
     public function getMyFamilyUnitData($id, $user_id) {
        $admin_obj = new Admin;
        $user_obj = new User;

        $ptd_id_genrate = str_replace('-', ' ', $id);
        $data = $admin_obj->getMyFamily($ptd_id_genrate, $user_id);
        $family_member = $admin_obj->getFamilyMember($ptd_id_genrate, $user_id);

        $tenant_details = $admin_obj->getTenantDetails($ptd_id_genrate, $user_id);
   
        $car_details = $admin_obj->getCarDetails($ptd_id_genrate, $user_id);
     
        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $actualid = $getpropertyid->id;
        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;
        return view('admin.my-family-data', compact('family_member', 'tenant_details', 'car_details'));
  }

    public function getMaintenanceFeeByUserID($id, $user_id) {

        $admin_obj = new Admin;
        $user_obj = new User;

        $ptd_id_genrate = str_replace('-', ' ', $id);
        $data = $admin_obj->getMaintenanceFee($ptd_id_genrate, $user_id);

        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $actualid = $getpropertyid->id;

        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;

        return view('admin.property-maintenancefee', compact('township_name', 'ptd_id_genrate', 'id', 'data', 'user_id'));
    }

      public function UpdateEmergencyContact(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        $user_type = Auth::user()->type;
        if ($user_type == 5) {
            $contact_status = 1;
            $contact_type = 5;
        } else {
            $contact_status = 0;
            $contact_type = 6;
        }
        if (empty($request->image_file)) {
            $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'name' => $postData['name'],
                'cell_number' => $postData['cell_number'],
                'status' => $contact_status,
                'save_type' => $contact_type,
            );
        } else {
            $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
            $upload_image = $request->image_file->move(public_path('icon'), $imageName);
            $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'name' => $postData['name'],
                'cell_number' => $postData['cell_number'],
                'icon' => url('/') . '/public/icon/' . $imageName,
                'status' => $contact_status,
                'save_type' => $contact_type,
            );
        }



        if (empty($id)) {
            $update_contact = $admin_obj->saveEmergencyContactData($dataArray);
        } else {
            $update_contact = $admin_obj->updateData($dataArray, $id);
        }

        if ($update_contact) {
          Session::flash('success', 'Contact update successfully.'); 
          return redirect('/admin/emergancy-contact');
          
        } else {
            return back()->with('success', 'Contact not update please try again.')->with('id', '');
        }
    }

    public function UpdateComplaint(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;

        $id = $postData['id'];
        $status = $postData['change_status'];

        $dataArray = array(
            'status' => $status
        );

        $update_complaint = $admin_obj->updateComplaint($dataArray, $id);


        if ($update_complaint) {
            return back()->with('success', 'Contact update successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Contact not update please try again.')->with('id', '');
        }
    }

    public function Updatevisitor(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;

        $id = $postData['id'];
        $status = $postData['change_status'];

        $dataArray = array(
            'invitation_status' => $status
        );

        $update_visitor = $admin_obj->updateVisitor($dataArray, $id);


        if ($update_visitor) {
            return back()->with('success', 'Contact update successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Contact not update please try again.')->with('id', '');
        }
    }

  public function UpdateHandymanContact(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        if (empty($request->image_file)) {
            $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'name' => $postData['name'],
                'cell_number' => $postData['cell_number'],
                'description' => $postData['description'],
                'type' => $postData['type'],
            );
        } else {
            $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
            $upload_image = $request->image_file->move(public_path('coupon-images'), $imageName);
            $dataArray = array(
               'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'name' => $postData['name'],
                 'cell_number' => $postData['cell_number'],
                'description' => $postData['description'],
                'type' => $postData['type'],
                'image' => url('/') . '/public/coupon-images/' . $imageName
            );
        }

        if (empty($id)) {
            $update_contact = $admin_obj->saveHandymanContactData($dataArray);
            $save = 'save';
        } else {
            $update_contact = $admin_obj->updateHandymanData($dataArray, $id);
            $save = 'update';
        }

        if ($update_contact) {

          $users = $admin_obj->getUsersbyPropertyId($this->getSessionId());
          
          foreach ($users as $key => $value) {
            
            /* Push notifications */
            $Message = array('title' => "Notification",
                "text" => 'New Handyman Added',
                "customers" => $value->mobile_number);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            /* Push notification end */

          }

          Session::flash('success', 'Contact ' . $save . ' successfully.'); 
          return redirect('/admin/handyman');   
           
        } else {
            return back()->with('success', 'Contact not update please try again.')->with('id', '');
        }
    }

    public function UpdateNotice(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;

        $id = $postData['id'];
        $subject = $postData['subject'];
        $description = $postData['description'];
        $end_date = $postData['end_date'];
        if (!empty($request->image_file)) {
           $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
           $upload_image = $request->image_file->move(public_path('notice-images'), $imageName);
            $dataArray = array(
                'subject' => $subject,
                'description' => $description,
                'end_date' => $end_date,
                'image' =>  url('/') . '/public/notice-images/' . $imageName
            );
        }else{
            $dataArray = array(
                'subject' => $subject,
                'description' => $description,
                'end_date' => $end_date
            );
        }
        $update_notice = $admin_obj->updateNotice($dataArray, $id);
        if ($update_notice) {
            return back()->with('success', 'Notice update successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Notice not update please try again.')->with('id', '');
        }
    }

   public function saveNotice(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
         if (empty($request->image_file)) {
                  $dataArray = array(
                        'ptd_id' => $this->getSessionPtdId(),
                        'property_id'=>$this->getSessionId(),
                        'subject' => $postData['subject'],
                        'description' => $postData['description'],
                        'end_date' => $postData['end_date']
                    );
        } else {
            $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
            $upload_image = $request->image_file->move(public_path('notice-images'), $imageName);
            $dataArray = array(
                        'ptd_id' => $this->getSessionPtdId(),
                        'property_id'=>$this->getSessionId(),
                        'subject' => $postData['subject'],
                        'description' => $postData['description'],
                        'end_date' => $postData['end_date'],
                        'image' =>  url('/') . '/public/notice-images/' . $imageName
                    ); 
        }

       $add_notice = $admin_obj->saveNotice($dataArray);

       if ($add_notice) {
            $userlist = $admin_obj->getPropertyUsers($this->getSessionId());
            $mobile_string = '';
            foreach ($userlist as $key => $value) {
                if($value->mobile_number != ''){
                    $mobile_string .= $value->mobile_number . ';';
               }
            }

            /* Push notifications */
            $Message = array('title' => "Notice",
                "text" => $postData['subject'],
                "customers" => $mobile_string);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            /* Push notification end */

            Session::flash('success', 'Notice save successfully.'); 
           return redirect('/admin/ann-notice-board');
        } else {
            return back()->with('success', 'Notice not update please try again.')->with('id', '');
        }
    }

    public function getComplaintIndex(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $record = $admin_obj->getComplaint();

        return view('admin.complaint', compact('record'));
    }

    public function getTransactionData($maintenance_id, $ptd_id) {

        $admin_obj = new Admin;
        $transactiondata = $admin_obj->getTransactionDetails($maintenance_id, urldecode($ptd_id));
        $data_html = '';
        if ($transactiondata) {
            if (isset($transactiondata[0]->payment_status) && $transactiondata[0]->payment_status == 1) {
                $status = 'Completed';
            } else {
                $status = 'Pending';
            }

            $data_html = '';
            $data_html .= '<div class="col-xs-12 col-ms-12 col-md-12 payment_title">
			<p><span>Maintenance of ' . date('M', strtotime($transactiondata[0]->created_date)) . ' Month</span></p>
			</div>';

            $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
			    <p><b>Name:</b</p>
			    </div>';
            $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
			    <p>' . $transactiondata[0]->name . '</p>
			    </div>';
            $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
			    <p><b>Amount :</b></p>
			     </div>';
            $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
			   <p>' . number_format((float) $transactiondata[0]->amount, 2, '.', '') . '</p>
			    </div>';
            $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
			    <p><b>Due Amount:</b></p>
					</div>';
            $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
			    <p>' . number_format((float) $transactiondata[0]->previous_due, 2, '.', '') . '</p>
			    </div>';
            $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
			    <p><b>Total Amount:</b></p>
			    </div>';
            $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
			    <p>' . number_format((float) $transactiondata[0]->total_amount, 2, '.', '') . '</p>
			    </div><hr/>';
            if (!empty($transactiondata[0]->slug)) {
                $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
				<p><b>Transaction Date:</b></p>
				</div>';
                $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
                                <p>' . date('d M Y', strtotime($transactiondata[0]->transaction_date)) . '</p>
                                </div>';
                $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
                                <p><b>Transaction Time:</b></p>
                                </div>';
                $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
                                <p>' . date('h:i:s A', strtotime($transactiondata[0]->transaction_date)) . '</p>
                                </div>';

                $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
                                <p><b>Status:</b></p>
                                </div>';
                $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
                                <p>' . $status . '</p>
                               </div>';

                $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
                                <p><b>Transaction Id:</b></p>
                                </div>';
                $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
                                <p>' . $transactiondata[0]->slug . '</p>
                                </div>';
            } else {
                $data_html .= '<div class="col-sm-4 col-xs-6 payment_text">
                                <p><b>Status:</b></p>
                                </div>';
                $data_html .= '<div class="col-sm-8 col-xs-6 payment_text">
                                <p>Pending</p>
                                </div>';
            }

            echo $data_html;
        }
    }

    public function update_complaint_form(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        $status = $postData['change_status'];
        $update_complaint = $admin_obj->updateComplaintById($id, $status);
    }

      public function managePropertyById() {
      $id=$this->getSessionId();
     $setid=isset(Session::get('Property')->ptd_id) ? Session::get('Property')->ptd_id:'';
     $township_name=isset(Session::get('Property')->township_name) ? Session::get('Property')->township_name:'';
      return view('admin.manage', compact('id', 'setid', 'township_name')); 
       
    }

    public function deleteContact($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deletecontact($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function deleteMaintenanceFee($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deletemaintenancefee($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function actionChange($id, $status) {
        $admin_obj = new Admin;
        $delete = $admin_obj->actionChange($id, $status);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function changeContactStatus($id, $status) {
        $admin_obj = new Admin;
        $delete = $admin_obj->changeContactStatus($id, $status);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }


    public function changeSecurityStatus(Request $request) {
        $admin_obj = new Admin;
           $postData = $request->all();
         $updateArray=array('status'=>$postData['status']);
         $whereArray=array('security_id'=>$postData['security_id']);
        $update = $admin_obj->updateTableData('security_guard',$updateArray,$whereArray);
        if ($update) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function familyActionChange($id, $status) {
        $admin_obj = new Admin;
        $delete = $admin_obj->familyActionChange($id, $status);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function deletevisitor($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deletevisitor($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function deleteHandymanContact($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deleteHandymanContact($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function deleteNotice($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deleteNotice($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

  public function getReportComplaintByPtdId() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $record = $admin_obj->get_complaintByPtdId($property_id); 
        return view('admin.complaint', compact('record'));
    }

  public function securityLink() {
        $admin_obj = new Admin;
        $property_id  = $this->getSessionId();
        
        $where  =  array('property_id' => $this->getSessionId());
        $record  =  $admin_obj->getWhere('security_guard', $where);

        return view('admin.security',compact('property_id','record'));
    }

   public function getUnit() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $unit  = $admin_obj->getActiveUnits($property_id);
        $unit = $admin_obj->getPropertyUnit($this->getSessionId());
        return view('admin.unit', compact('unit'));
    }

  public function getVisitorByPtdId() {
        $Invitation = new Invitation;
        $record = $Invitation->visitingListByProperty($this->getSessionId()); 
        return view('admin.myvisitor', compact('record'));
    }

    public function todayVisitorByPtdId($id) {
        $admin_obj = new Admin;

        $ptd_id_genrate = str_replace('-', ' ', $id);
        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $record = $admin_obj->todayMyVisitorByPtdId($ptd_id_genrate);
        $actualid = $getpropertyid->id;
        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;

        return view('admin.todayvisitor', compact('township_name', 'ptd_id_genrate', 'id', 'record', 'actualid'));
    }

      public function getAnnounceNoticeByPtdId() {
        $admin_obj = new Admin;
          $property_id = $this->getSessionId();
       $get_record = $admin_obj->get_AnnounceNoticeByPtdId($property_id);
        return view('admin.notice', compact('get_record'));
    }

       public function getInboxByPtdId() {
        $admin_obj = new Admin;
         $property_id = $this->getSessionId();
        $user_id = Auth::user()->id;
        $data = $admin_obj->getInboxByPtdId($property_id, $user_id);
     
        return view('admin.message-inbox', compact('data'));
    }

   public function getSentByPtdId() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $user_id = Auth::user()->id;
        $data = $admin_obj->getSentByPtdId($property_id, $user_id);
        return view('admin.message-sent', compact('data'));
    }

     public function getInsurance() {
        $admin_obj = new Admin;
          $property_id = $this->getSessionId();
        $get_record = $admin_obj->get_InsuranceByPtdId($property_id);
        return view('admin.insurance', compact('get_record'));
    }

   public function getHandyman() {  
        $admin_obj = new Admin; 
        $property_id = $this->getSessionId();  
        $record_data = $admin_obj->get_HandymanContact($property_id);

        $get_record = [];
        foreach ($record_data as $key => $value) {
          $get_count = $admin_obj->getCount($value->id, '1');
          $value->count = $get_count;
          array_push($get_record, $value);
        } 

       $coupon_type = $admin_obj->getEcouponType();

      return view('admin.handyman-contact', compact('get_record', 'coupon_type'));
    }

     public function getCoupon() {
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $record_data = $admin_obj->getCoupon($property_id);
        $get_record = [];
        foreach ($record_data as $key => $value) {
          $get_count = $admin_obj->getCount($value->id, '2');
          $value->count = $get_count;
          array_push($get_record, $value);
        } 
        $coupon_type = $admin_obj->getEcouponType();
        return view('admin.coupon', compact('get_record', 'coupon_type'));
    }

     public function addCouponIndex() {
         $admin_obj = new Admin;
        $coupon_type = $admin_obj->getEcouponType();
        return view('admin.coupon-add', compact('coupon_type'));
    }

 public function Updatecoupon(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        $description = $postData['description'];
        if (empty($description)) {
            $description = " ";
        }
     

        if (empty($request->image_file)) {
            $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'title' => $postData['title'],
                'subject' => $postData['subject'],
                'description' => $postData['description'],
                'type' => $postData['type'],
            );
        } else {
            $imageName = time() . '.' . $request->image_file->getClientOriginalExtension();
            $upload_image = $request->image_file->move(public_path('coupon-images'), $imageName);
            $dataArray = array(
                'ptd_id' => $this->getSessionPtdId(),
                'property_id'=>$this->getSessionId(),
                'description' => $postData['description'],
                'subject' => $postData['subject'],
                'title' => $postData['title'],
                'image' => url('/') . '/public/coupon-images/' . $imageName,
                'type' => $postData['type']
            );
        }

        if (empty($id)) {
            $update_contact = $admin_obj->saveCouponData($dataArray);
            $save_set = 'save';
        } else {
            $update_contact = $admin_obj->updateCouponData($dataArray, $id);
            $save_set = 'update';
        }

        if ($update_contact) {


          $users = $admin_obj->getUsersbyPropertyId($this->getSessionId());
          
          foreach ($users as $key => $value) {
            
            /* Push notifications */
            $Message = array('title' => "Notification",
                "text" => 'New Coupon Added',
                "customers" => $value->mobile_number);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            /* Push notification end */

          }

            Session::flash('success', 'Contact ' . $save_set . ' successfully.'); 
           return redirect('/admin/e-flyer-coupon');
         
        } else {
            return back()->with('success', 'Contact not update please try again.')->with('id', '');
        }
    }

    public function deleteCoupon($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deleteCoupon($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function deleteComplaint($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deleteComplaint($id);
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }

    public function addMaintenanceFeeByUserID($id, $user_id) {
        $admin_obj = new Admin;
        $ptd_id_genrate = str_replace('-', ' ', $id);

        $getpropertyid = $admin_obj->get_propertyid($ptd_id_genrate);
        $actualid = $getpropertyid->id;

        $property_obj = new Property;
        $data_property = $property_obj->getPropertyById($actualid);
        $township_name = $data_property->township_name;

        return view('admin.maintenance-fees-add', compact('township_name', 'ptd_id_genrate', 'id', 'user_id'));
    }

    public function addMaintenanceFess(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $user_obj = new User;

        $user_data = $user_obj->getUserById($postData['user_id']);
        $user_id = $postData['user_id'];
        $ptd_id = $this->getSessionPtdId();
        $charge = $postData['charge'];
        $balance = $postData['balance'];
        $amount_due = $postData['amount_due'];
        $remark = $postData['remark'];
        $invoice_month = $postData['invoice_month'];
        $path = base_path();
        $file = $request->file('pdf_file');

        if ($file->getClientMimeType() !== 'application/pdf') {
            return back()->with('success', 'Please upload pdf file only.');
        }

        $pdfName = 'pdf' . time() . '.' . $request->pdf_file->getClientOriginalExtension();
        $upload_pdf = $request->pdf_file->move($path . '/assets/pdf', $pdfName);
        $dbsavefilename = asset('assets/pdf/' . $pdfName . '');
        $url = $this->billplzURL.'v2/bills';
        $ch = curl_init($url);
        $fields = array(
            'collection_id' => 'kvxuid40',
            'email' => 'example@mailinator.com',
            'name' => 'Johnathan',
            'amount' => $balance * 100,
            'mobile' => '+60123456789',
            'callback_url' => 'http://api.dexbytes.in/condo-management/webhook',
            'deliver' => 'false'
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, "323d17f7-6fa7-45b0-92a1-ce6b39c0f4d5");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);

        if ($result === true) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        $result_set = json_decode($result, true);
        curl_close($ch);
        $dataArray = array(
            'ptd_id' => $ptd_id,
            'user_id' => $user_id,
            'pay_amount' => $charge,
            'amount' => $charge,
            'total_amount' => $balance,
            'previous_due' => $amount_due,
            'remarks' => $remark,
            'invoice_month' => $invoice_month,
            'pdfname' => $pdfName,
            'pdf_url' => $dbsavefilename,
            'payment_url' => $result_set['url'],
        );
        $update_maintenance = $admin_obj->saveMaintenanceData($dataArray);

        if ($update_maintenance) {

            /* Push notifications */
            $text_message = "Dear " . $user_data->name . ", Your maintenance of " . $invoice_month . " month is RM" . $balance;
            $Message = array('title' => "Maintenance of " . $invoice_month . ' month',
                "text" => $text_message,
                "customers" => $user_data->mobile_number);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            /* Push notification end */

            return back()->with('success', 'Insert record successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Insert record not update please try again.')->with('id', '');
        }
    }

    public function updateMaintenanceFees(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $user_obj = new User;

        $id = $postData['id'];
        $pdf_name = $postData['pdf_name'];
        $charge = $postData['charge'];
        $balance = $postData['balance'];
        $amount_due = $postData['amount_due'];
        $remark = $postData['remark'];

        $payment_status = $postData['payment_status'];
        $invoice_month = $postData['invoice_month'];


        if (isset($postData['pdf_file'])) {
            $pdf_set = $postData['pdf_file'];
        } else {
            $pdf_set = '';
        }
        if (empty($pdf_set)) {
            $dataArray = array(
                'pay_amount' => $charge,
                'amount' => $charge,
                'total_amount' => $balance,
                'previous_due' => $amount_due,
                'remarks' => $remark,
                'invoice_month' => $invoice_month,
                'payment_status' => $payment_status,
            );
        } else {
            $path = base_path();
            $file = $request->file('pdf_file');
            if ($file->getClientMimeType() !== 'application/pdf') {
                return back()->with('success', 'Please upload pdf file only.');
            }
            $oldfile = $path . '/assets/pdf/' . $pdf_name;
            $pdfName = 'pdf' . time() . '.' . $request->pdf_file->getClientOriginalExtension();
            $upload_pdf = $request->pdf_file->move($path . '/assets/pdf', $pdfName);
            $dbsavefilename = asset('assets/pdf/' . $pdfName . '');

            if (file_exists($oldfile)) {
                unlink($oldfile);
            }

            $dataArray = array(
                'pay_amount' => $charge,
                'amount' => $charge,
                'total_amount' => $balance,
                'previous_due' => $amount_due,
                'remarks' => $remark,
                'invoice_month' => $invoice_month,
                'payment_status' => $payment_status,
                'pdfname' => $pdfName,
                'pdf_url' => $dbsavefilename,
            );
        }

        $update_maintenance = $admin_obj->updateMaintenanceData($dataArray, $id);


        if ($update_maintenance) {
            return back()->with('success', 'Update record successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Record not update please try again.')->with('id', '');
        }
    }

  public function maintenanceDetail() {
       $admin_obj = new Admin;
       $unit = $admin_obj->getPropertyUnit($this->getSessionId());
       return view('admin.maintenance-detail', compact('unit'));    
    }

    public function invoiceCreate($id) {
   
        $user_obj = new User;
        $admin_obj = new Admin;
        $unitData = $admin_obj->getUnitById($id);  
        $propery_id = $this->getSessionId();
        $unit_user = $admin_obj->getUnitUser($propery_id, $id); 
        return view('admin.invoice-detail', compact('unitData', 'id', 'unit_user'));
    }

    public function UpdateRcMcUser(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $user_obj = new User;

        $id = $postData['id'];
        $name = $postData['name'];
        $mobile_number = $postData['mobile_number'];
        $type = $postData['change_type'];
        if (!empty($postData['password'])) {
            $dataArray = array(
                'name' => $name,
                'mobile_number' => $mobile_number,
                'type' => $type,
                'password' => bcrypt($postData['password'])
            );
        } else {
            $dataArray = array(
                'name' => $name,
                'mobile_number' => $mobile_number,
                'type' => $type,
            );
        }

        $update_user = $admin_obj->UpdateRcMcUser($dataArray, $id);

        if ($update_user) {
            return back()->with('success', 'Update user successfully.')->with('id', '');
        } else {
            return back()->with('success', 'User not update please try again.')->with('id', '');
        }
    }

    public function changePassword() {
        return view('admin.change-password');
    }

    public function addMaintenance(Request $request) {
        $postData = $request->all();
        $admin_obj = new Admin;
        $user_obj = new User;
        $unit_id = $postData['unit_id'];
        $ptd_id = $this->getSessionPtdId();
        $total_subtotal = $postData['total_subtotal'];
        $tax_pre = $postData['tax_pre'];
        $tax_amount = $postData['tax_amount'];
        $grand_total = $postData['grand_total'];         
        $invoice_date = $postData['invoice_date'];
        $due_due = $postData['due_due'];
        $item_list = [];
        foreach($postData['title'] as $key => $values){
            $item_list[] = array('title' => $values ,'description' => $postData['desc'][$key] , 'quantity' => $postData['qty'][$key], 'amount' => $postData['amount'][$key], 'subtotal' => $postData['subtotal'][$key]);
        }

        $path = base_path();
        $file = $request->file('pdf_file');

        if ($file->getClientMimeType() !== 'application/pdf') {
            return back()->with('success', 'Please upload pdf file only.');
        }

        $pdfName = 'pdf' . time() . '.' . $request->pdf_file->getClientOriginalExtension();
        $upload_pdf = $request->pdf_file->move($path . '/assets/pdf', $pdfName);
        $dbsavefilename = asset('assets/pdf/' . $pdfName . '');
        $url = $this->billplzURL.'v2/bills';
        $ch = curl_init($url);

        $unit_user = $admin_obj->getUnitUser($this->getSessionId(), $unit_id); 

        $fields = array(
            'collection_id' => 'kvxuid40',
            'email' => $unit_user['0']->email,
            'name' => $unit_user['0']->name,
            'amount' => $grand_total * 100,
            'mobile' => '+60123456789',
            'callback_url' => 'http://api.dexbytes.in/condo-management/webhook',
            'deliver' => 'false'
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERPWD, "323d17f7-6fa7-45b0-92a1-ce6b39c0f4d5");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
       
        if ($result === true) {
            $info = curl_getinfo($ch);
            curl_close($ch);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        $result_set = json_decode($result, true);
        curl_close($ch);
        $dataArray = array(
            'ptd_id' => $ptd_id,
            'unit_id' => $unit_id,
            'user_id' => 0,
            'invoice_date' => $invoice_date,
            'item_list' => json_encode($item_list),
            'due_due' => $due_due,
            'amount' => $total_subtotal,
            'tax_percentage' => $tax_pre,
            'tax_amount' => $tax_amount,
            'total_amount' => $grand_total,
            'previous_due' => 0,
            'remarks' => "",
            'invoice_month' => date('F', strtotime($invoice_date)),
            'pdfname' => $pdfName,
            'pdf_url' => $dbsavefilename,
            'payment_url' => $result_set['url'],
        );
        $update_maintenance = $admin_obj->saveMaintenanceData($dataArray);

        if ($update_maintenance) {
             $mobile_string = '';
            $userlist = $admin_obj->getUnitUsers($unit_id);
            $mobile_string = '';
            foreach ($userlist as $key => $value) {
                if($value->mobile_number != ''){
                    $mobile_string .= $value->mobile_number . ';';
               }
            }

            $text_message = "Your maintenance of " .date('F', strtotime($invoice_date)) . " month is " . $grand_total;
            $Message = array('title' => "Maintenance of " . date('F', strtotime($invoice_date)) . ' month',
                "text" => $text_message,
                "customers" => $mobile_string);

            $Push_Model = new Push;
            $Push_Model->send($Message);
            

            return back()->with('success', 'Invoice added successfully.')->with('id', '');
        } else {
            return back()->with('success', 'invoice record not update please try again.')->with('id', '');
        }
    }

    public function UpdateUnit(Request $request){
        $postData = $request->all();
        $admin_obj = new Admin;
        $id = $postData['id'];
        $dataArray = array(
                'unit_ptd' => $postData['unit_ptd'],
                'address' => $postData['address'],
                'unit_number' => $postData['house_number'],
                'block_number' => $postData['block_number'],
            );
        $update = $admin_obj->updateTableData('property_units',$dataArray,['id' => $id]);
        if ($update) {
            return back()->with('success', 'Unit update successfully.')->with('id', '');
        } else {
            return back()->with('success', 'Unit not update please try again.')->with('id', '');
        }
    }

    public function getAllPropertyData($id, $unit_id) {
        $admin_obj = new Admin;
        $user_obj = new User;
        $ptd_id_genrate = $this->getSentByPtdId();
        $unit_property = $admin_obj->getMaintenancedetail($ptd_id_genrate,$unit_id);
       return view('admin.property-user-data', compact('unit_property'));
    }

    public function getPropertyData($ptd_id, $unit_id, $id) {
        $admin_obj = new Admin;
        $user_obj = new User;
        $ptd_id_genrate = str_replace('-', ' ', $id);

        $unit_property = $admin_obj->getMaintenanceFeesById($id);
        return view('admin.property-data', compact('unit_property'));
    }
    
   public function deleteUnit (Request $request){
      $postData = $request->all();
      $admin_obj = new Admin;
      $unit_id = $postData['unit_id'];
      $user_id = Auth::user()->id;
      $where  =  array('unit_id' => $unit_id, 'property_id' => $this->getSessionId());
      $exist  =  $admin_obj->getWhere('unit_user_relation', $where);

      if($exist){
           $unitdelete =  $admin_obj->updateTableData('property_units', array('status'=> 2 ) , array('id' => $unit_id));
           $del_response = $admin_obj->updateTableData('unit_user_relation',array('status'=> 2 ) , array('unit_id'=> $unit_id));
      if($del_response){
         echo json_encode(array('response'=>1,'message'=>'Deleted Successfully!'));  
      }else{
          echo json_encode(array('response'=>0,'message'=>'Delete failed,Please try again'));
      } 
      }else{
          $where['status']=2;
          $insert_res=$admin_obj->insertData('unit_user_relation',$where);
          echo json_encode(array('response'=>1,'message'=>'deleted Successfully!'));    
      }

       
    }

   public function getSessionId(){
       if(isset(Session::get('Property')->id)){
         return Session::get('Property')->id;
       }else{
        return false;
       } 
  }

    
  public function sessionProperty(){
    return  Session::get('Property'); 
  }
    
    
   public function setproperty($id, $type){
        $property_obj = new Property;
        $Property = $property_obj->getPropertyById($id);
        Session::put('Property', $Property);     
        
        if($type == "menu" ){
           return redirect('/admin/manage-property');   
        }
        if($type == "manage" ){
          return redirect('/rcmc-admin');      
        }
    }

    public function getSessionPtdId(){
       if(isset(Session::get('Property')->ptd_id)){
         return Session::get('Property')->ptd_id;
       }else{
        return false;
       } 
    }
    
   public function deleteEmail($id) {
        $admin_obj = new Admin;
        $delete = $admin_obj->deleteRow('message',array('id'=>$id));
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }
    }
    

    public function deletesecurity(Request $request){
          $admin_obj = new Admin;
         $postData = $request->all();
           $delete = $admin_obj->deleteRow('security_guard',array('security_id'=>$postData['security_id']));
        if ($delete) {
            return response()->json(['response' => '1']);
        } else {

            return response()->json(['response' => '0']);
        }

    }

    public function accountTransaction(Request $request){
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        $account = $admin_obj->getAccountTransaction($property_id);
        $withdrawalAmount = 0;
        foreach ($account as $key => $value) {
          if ($value->payment_status == 1) {
            $withdrawalAmount = $withdrawalAmount + $value->amount;
          }
        } 
        return view('admin.account', compact('property_id', 'account','withdrawalAmount'));
    }

    public function withdrawalAmount($amount){

      $admin_obj = new Admin;
      $property_id = $this->getSessionId();

      $percentage = 97.5;
      $newAmount = ($percentage / 100) * $amount;
      return view('admin.amount-withdrawal', compact('newAmount','property_id'));
    }

    public function saveWithdrawDetail(Request $request){
      $admin_obj = new Admin;
      $postData = $request->all();

      $account = $admin_obj->getAccountTransaction($postData['property_id']);
      
      $addData = $admin_obj->addWithdrawal($postData);

      if ($addData == 1) {
        foreach ($account as $key => $value) {
          $dataArray = array(
            'withdraw_status' => '1',
          );
          $update = $admin_obj->updateWithdrawStatus($dataArray, $value->maintenance_fee_id);
        }
        return 1;
      } else {
        return 0;
      } 
    }

    public function accountSetting(Request $request){
        $admin_obj = new Admin;
        $property_id = $this->getSessionId();
        return view('admin.setting', compact('property_id'));
    }

    public function saveSetting(Request $request){
      $admin_obj = new Admin;
      $postData = $request->all();
      
      $addData = $admin_obj->addSetting($postData);
      // print_r($addData);
      // die;
      if ($addData == 1) {
        return 1;
      }
      return 0;
    }

    public function userRemnider(Request $request){
      $admin_obj = new Admin;
      $postData = $request->all();

      $pending = $admin_obj->getPendingMaintenance($postData['ptd_id'], $postData['unit_id']);

      foreach ($pending as $key => $value) {
         
        /* Push notifications */
        $text_message = "Your maintenance of " .date('F', strtotime($value->invoice_date)) . " month was remaining" ;
        $Message = array('title' => 'Reminder',
            "text" => $text_message,
            "customers" => $value->mobile_number);
        $Push_Model = new Push;
        $pushDone = $Push_Model->send($Message);
        /* Push notification end */

      }

      return 1;
    }

    public function removeTemanfromManagement(Request $request){
      $admin_obj = new Admin;
      $postData = $request->all();


      $dataArray = array(
                   'delete_status' => 1
                );

      $delete = $admin_obj->removeTeman($dataArray, $postData['user_id']);
      
      if ($delete == 1) {
        return 1;
      }
      return 0;
    }

    public function deleteTeman(Request $request){
      $admin_obj = new Admin;
      $postData = $request->all();

      $delete = $admin_obj->deleteTeman($postData['user_id']);
      
      if ($delete == 1) {
        return 1;
      }
      return 0;
    }
}
