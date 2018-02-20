<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Security extends Model {

    public function get_visitor_user($date, $property_id) {
        
           $query = DB::table('visitors')
                ->join('visitor_pass', 'visitors.cell_number', '=', 'visitor_pass.cell_number')
                ->where('visitor_pass.property_id', $property_id)              
                ->where('visitor_pass.invitation_status', 1)
                ->where('visitor_pass.invitation_status', 4)
                ->orderBy('visitor_pass.created_date', 'DESC')
                ->get();

        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function get_visitor_info($id) {
        $query = DB::table('visitors')
                ->Join('visitor_pass', 'visitors.cell_number', '=', 'visitor_pass.cell_number')
                ->where('visitors.id', $id)
                ->get(['visitors.*', 'visitor_pass.*', 'visitor_pass.id as visitor_pass_id']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getproperty($property_id) {

        $query = DB::table('property')->where('id', $property_id)->get(['property.*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }

    }

    public function saveVisitor($dataArray, $visitor_pass_array) {
        $visitor_pass_id = DB::table('visitor_pass')->insertGetId($visitor_pass_array);
        if (!empty($visitor_pass_id)) {
            $dataArray['visitor_code'] = 'GP000' . $visitor_pass_id;
        }
        return DB::table('visitors')->insertGetId($dataArray);
    }

    public function update_status($table, $id, $data_array) {
        return DB::table($table)
                        ->where('id', $id)
                        ->update($data_array);
    }

    public function checkSecurityLogin($username, $password) {
        return DB::table('security_guard')
                        ->where('username', $username)
                        ->where('password', $password)
                        ->first();
    }

    public function securityUser($security_id) {
        return DB::table('security_guard')
                        ->where('security_id', $security_id)
                        ->first(['security_guard.security_id','security_guard.property_id','security_guard.security_name','security_guard.username']);
    }

    public function securityPasses($property_id) {
        return DB::table('visiting_card')
                        ->Join('visitors', 'visiting_card.visitor_user_id', '=', 'visitors.id')
                        ->where('property_id', $property_id)
                        ->whereIn('invite_status', [1,3])
                        ->get(['visiting_card.id as visiting_id','visitors.name','visitors.visitor_nric','visitors.mycard_image','visiting_card.car_number','visiting_card.total_vistior','visiting_card.invite_status','visitors.cell_number']);
    }

}
