<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Property extends Model
{
	public function get_property(){
        
        return DB::table('property')->get();
    }

    public function get_user_property($user_id){
        $properties = DB::table('property')
                ->join('property_units as prop', 'prop.property_id', '=', 'property.id')
                ->join('unit_user_relation as usp', 'usp.unit_id', '=', 'prop.id')
                ->where('usp.user_id', '=', $user_id)
                ->select('property.*', 'prop.unit_ptd', 'prop.block_number', 'prop.unit_number', 'prop.address', 'usp.unit_id')
                ->get();

        return $properties;
    }

    public function get_property_by_number($number){

        $users = DB::table('users')->where('mobile_number',$number)->where('status','1')->where('type','1')->orWhere('type','2')->get();
        if (count($users) != 0) {
            $properties = DB::table('property')
                ->join('property_units as prop', 'prop.property_id', '=', 'property.id')
                ->join('unit_user_relation as usp', 'usp.unit_id', '=', 'prop.id')
                ->join('users as users', 'users.id', '=', 'usp.user_id')
                ->where('users.mobile_number', '=', $number)
                ->select('property.*', 'prop.unit_ptd', 'prop.block_number', 'prop.unit_number', 'prop.address', 'usp.unit_id','users.name')
                ->get();
        return $properties;   
        }
        return [];
    }



    public function getPropertyById($id){    
        return DB::table('property')->where('id',$id)->first();
    }
    
    public function deleteproperty($id){
        DB::table('complain')->where('property_id',$id)->delete();
        DB::table('emergency-contact')->where('property_id',$id)->delete();
        DB::table('e_coupon')->where('property_id',$id)->delete();
        DB::table('handyman')->where('property_id',$id)->delete();
        DB::table('insurance')->where('property_id',$id)->delete();
        DB::table('maintenance_fee')->where('property_id',$id)->delete();
        DB::table('message')->where('property_id',$id)->delete();
        DB::table('my-family')->where('property_id',$id)->delete();
        DB::table('notice')->where('property_id',$id)->delete();
        DB::table('property_units')->where('property_id',$id)->delete();
        DB::table('property_units')->where('property_id',$id)->delete();
        DB::table('unit_user_relation')->where('property_id',$id)->delete();
         // DB::table('users')->where('property_id',$id)->delete();
        DB::table('visitor_pass')->where('property_id',$id)->delete();
        return DB::table('property')->where('id',$id)->delete();
    }

    public function updateData($array,$id){
        return DB::table('property')
            ->where('id', $id)
            ->update($array);
    }

    public function get_units_by_property($property_id){
        //return DB::table('property_units')->where('property_id',$property_id)->get();
        return DB::table('property')
                ->join('property_units', 'property.id', '=', 'property_units.id')
                ->where('property_units.property_id', '=', $property_id)
                // ->select('property.*', 'prop.id as unit_id', 'prop.unit_ptd', 'prop.block_number', 'prop.unit_number', 'prop.address')
                ->get();;
    }

    public function getCountryCode($ptd_id){
        $countryCode = DB::table('property')->select('country_code')->where('ptd_id',$ptd_id)->first();
        return $countryCode->country_code;
    }
    
}
