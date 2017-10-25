<?php

namespace App\Http\Controllers;
use App\Models\User;
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

class AdminController extends Controller
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
        
        return view('admin.dashboard');
    }
    public function getAllUsers()
    {
        $user_obj = new User;
        $data = $user_obj->get_user();
        return view('admin.allusers',compact('data'));
    }
    public function getAllProperty()
    {
        $property_obj = new Property;
        $data = $property_obj->get_property();
        return view('admin.property',compact('data'));
    }
    public function addNewProperty()
    {
         $admin_obj = new Admin;
        $last_record = $admin_obj->get_last();
        
        if(empty($last_record)){
                $ptd_id_genrate = 'PTD '.date("m").date("y").'01';
                
            }else{
                $total = explode('PTD ', $last_record->ptd_id);
                $total_find = $total[1]+1;
                $ptd_id_genrate = 'PTD '.date("m").date("y").$total_find;
            } 
           
        return view('admin.property-add');
    }
    public function sendProperty(Request $request)
    {
        $postData = $request->all();
        $this->validate($request, [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $admin_obj = new Admin;
        $last_record = $admin_obj->get_last();

        $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
        $upload_image = $request->image_file->move(public_path('images'), $imageName);
        if($upload_image){
           if(empty($last_record)){
                $ptd_id_genrate = 'PTD '.date("m").date("y").'01';
                
            }else{
                $total = explode('PTD ', $last_record->ptd_id);

                $total_find = $total[1]+1;
                $ptd_id_genrate = 'PTD '.$total_find;
            } 
            $dataArray = array(
                    'ptd_id'        => $ptd_id_genrate,
                    'country'       => $postData['country_name'],
                    'township_name' => $postData['township_name'],
                    'zipcode'       => $postData['zipcode'],
                    'city_name'     => $postData['city_name'],
                    'address'       => $postData['address'],
                    'image'         => $imageName
                );
            $save_property = $admin_obj->saveData($dataArray);
            return back()->with('success','You have successfully added property.')->with('image',$imageName);
        }
        return back()
            ->with('success','error to add new property.')
            ->with('image','');
        //return view('admin.property-add');
    }
    public function deleteProperty($id)
    {
        $property_obj = new Property;
       $delete=$property_obj->deleteproperty($id);
       if($delete){
           return response()->json(['response'=>'1']);
       }else{

            return response()->json(['response'=>'0']);
       }

    }
    public function updateProperty(Request $request)
    {
        $postData = $request->all();
        
        $property_obj = new Property;
        $id = $postData['id'];
        if (isset($postData['image_file'])) {
            $image_set = $postData['image_file'];
        }else{
            $image_set = '';
        }
        if(empty($image_set)){
            
            $dataArray = array(
                    'country'       => $postData['country_name'],
                    'township_name' => $postData['township_name'],
                    'zipcode'       => $postData['zipcode'],
                    'city_name'     => $postData['city_name'],
                    'address'       => $postData['address'],

                );
        }else{
            $this->validate($request, [
                'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ]);
            $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
           
            $upload_image = $request->image_file->move(public_path('images'), $imageName);
            if($upload_image){
                $dataArray = array(
                    'country'       => $postData['country_name'],
                    'township_name' => $postData['township_name'],
                    'zipcode'       => $postData['zipcode'],
                    'city_name'     => $postData['city_name'],
                    'address'       => $postData['address'],
                    'image'         => $imageName
                );
            }else{
                $dataArray = array(
                    'country'       => $postData['country_name'],
                    'township_name' => $postData['township_name'],
                    'zipcode'       => $postData['zipcode'],
                    'city_name'     => $postData['city_name'],
                    'address'       => $postData['address'],
                );
            }
            
        }
        $update_property = $property_obj->updateData($dataArray,$id);
        if($update_property){
             return back()->with('success','You have successfully updates.')->with('image','');
         }else{
              return back()->with('success','You have error in image file.')->with('image','');
         }
          return back()->with('success','You have not updates.')->with('image','');
    }
    
}
