<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model {

    public function get_user() {
        return DB::table('users')->whereBetween('type', [1, 2])->orderBy('created_at', 'desc')->get();
    }

    public function getResidentByNumber($mobile_number) {
        return DB::table('users')->where('mobile_number', $mobile_number)->first();
    }

    public function getUserByPtdId($ptd_id) {

        return DB::table('users')->where('ptd_id', $ptd_id)->whereBetween('type', [1, 2])->orderBy('created_at', 'desc')->get();
    }

     public function getUsersByType($property_id, $type) {
            $query = DB::table('users') 
                 ->Join('unit_user_relation',[['unit_user_relation.user_id','=','users.id']])
                  ->where('users.type', $type)
                   ->where('unit_user_relation.property_id', $property_id)
                  ->groupBy('unit_user_relation.unit_id')
                  ->groupBy('unit_user_relation.user_id')
                   ->having('unit_user_relation.status', '=', '1')
                   ->get(['unit_user_relation.unit_id as unit_id',
                         'unit_user_relation.user_id as unit_user_id',
                         'unit_user_relation.status as unit_status',
                         'users.*']);
                    if ($query->isEmpty()) {
                        return false;
                    } else {
                        return $query;
                    }
       
    }

    public function get_last() {

        return DB::table('property')->select('ptd_id')->orderBy('id')->take(1)->get();
    }

    public function get_last_record() {

        return DB::table('complain')->select('ticket')->orderBy('id')->take(1)->first();
    }

    public function save_complaint($dataArray) {

        return DB::table('complain')->insertGetId($dataArray);
    }

    public function get_complaint($user_id, $ptd_id, $property_id, $unit_id) {

        return DB::table('complain')->where('user_id', $user_id)->where('property_id', $property_id)->where('unit_id', $unit_id)->orderBy('create_date', 'desc')->get();
    }

    public function cancel_complaint($id) {

        return DB::table('complain')
                        ->where('id', $id)
                        ->update(['status' => 3]);
    }

    public function updateProfile($array, $id) {

        return DB::table('users')
                        ->where('id', $id)
                        ->update($array);
    }

    public function updateVisitorProfile($array, $id) {

        return DB::table('visitors')
                        ->where('id', $id)
                        ->update($array);
    }

    public function getVisitorProfile($id) {

        return DB::table('users')->where('id', $id)->first();
    }

    public function getUserById($id) {
        return DB::table('users')->where('id', $id)->first();
    }

    public function getAboutUsOrTerms($page_key) {
        return DB::table('pages')->where('page_key', $page_key)->first();
    }

    public function checkusernumber($data) {
        return DB::table('users')->where('mobile_number', $data['mobile_number'])->where('type', $data['type'])->where('country_phone_code', $data['country_code'])->first();
    }

    public function checkuserotp($data) {
        return DB::table('users')->where('mobile_number', $data['mobile_number'])->where('type', $data['type'])->where('otp', $data['otp'])->where('nric', $data['nric'])->first();
    }

}
