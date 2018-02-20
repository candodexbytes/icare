<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model {

    public function get_subAdmin($property_id) {

        return DB::table('users')->where('property_id', $property_id)->whereBetween('type', [5, 6])->orderBy('created_at', 'desc')->get();
    }

   public function getUserByPtdId($property_id) {
        return DB::table('users')->where('property_id', $property_id)->whereBetween('type', [1, 2])->orderBy('created_at', 'desc')->get();
    }

    public function emailCheckUser($email) {

        return DB::table('users')->where('email', $email)->first();
    }

    public function mobileCheckUser($cell_number) {

        return DB::table('users')->where('mobile_number', $cell_number)->first();
    }

    public function saveUnitData($array) {

        return DB::table('property_units')->insert($array);
    }

    public function saveUserData($array) {

        return DB::table('users')->insert($array);
    }

    public function get_last() {

        return DB::table('property')->orderBy('id', 'desc')->take(1)->first();
    }

    public function get_lastptd($ptd_id) {

        return $query = DB::table('property_units')->where('ptd_id', $ptd_id)->orderBy('id', 'desc')->first();
    }

    public function saveData($array) {

        return DB::table('property')->insert($array);
    }

    public function get_emergencyContact($property_id) {
          return DB::table('emergency-contact')
          ->where('status', 1)
          ->where('property_id', $property_id)
          ->get(); 
    }



    public function getAllUsers($property_id){
           $query = DB::table('users') 
                ->Join('unit_user_relation',[['unit_user_relation.user_id','=','users.id']])
                ->whereBetween('users.type', [1, 2])
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

    public function getPropertyUsers($property_id){
           $query = DB::table('unit_user_relation') 
                ->Join('users',[['unit_user_relation.user_id','=','users.id']])
                ->whereBetween('users.type', [1, 2])
                ->where('unit_user_relation.property_id', $property_id)          
                ->groupBy('unit_user_relation.user_id')             
                ->get(['users.*']);
                    if ($query->isEmpty()) {
                        return false;
                    } else {
                        return $query;
                    }
    }

    public function getUnitUsers($unit_id){
           $query = DB::table('unit_user_relation') 
                ->Join('users',[['unit_user_relation.user_id','=','users.id']])
                ->whereBetween('users.type', [1, 2])
                ->where('unit_user_relation.unit_id', $unit_id)          
                ->groupBy('unit_user_relation.user_id')             
                ->get(['users.*']);
                    if ($query->isEmpty()) {
                        return false;
                    } else {
                        return $query;
                    }
    }

    public function getPropertyUnit($property_id) 
     {
       $query = DB::table('property_units')->where('property_id', $property_id)->get();
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getUnitUser($property_id, $unit_id) {

        $query = DB::table('users') 
                 ->Join('unit_user_relation',[['unit_user_relation.user_id','=','users.id']])
                  ->where('unit_user_relation.property_id', $property_id)
                  ->where('unit_user_relation.unit_id', $unit_id)
                  ->whereBetween('users.type', [1, 2])
                  ->get();

        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }


    public function getAllUnitUsers($property_id , $type){  
        if($type == 0){      
          $query = DB::table('unit_user_relation')
                        ->Join('users',[['unit_user_relation.user_id','=','users.id']])
                        ->Join('property_units',[['property_units.id','=','unit_user_relation.unit_id']])
                        ->where('unit_user_relation.property_id', $property_id)                        
                       ->get(['property_units.*','users.*','unit_user_relation.*']); 
        }else{
            $query = DB::table('unit_user_relation')
                        ->Join('users',[['unit_user_relation.user_id','=','users.id']])
                        ->Join('property_units',[['property_units.id','=','unit_user_relation.unit_id']])
                        ->where('unit_user_relation.property_id', $property_id)  
                        ->where('users.type', $type)                        
                        ->get(['property_units.*','users.*','unit_user_relation.*']); 
        }  
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }
    
    public function getUserUnits($unit_id,$user_id){
         $query = DB::table('property_units') 
                 ->Join('unit_user_relation',[['unit_user_relation.unit_id','=','property_units.id']])
                 ->where('unit_user_relation.unit_id', $unit_id)
                  ->where('unit_user_relation.user_id', $user_id)
                  ->select('property_units.*')->get();
         
            if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function updateData($dataArray, $id) {
        return DB::table('emergency-contact')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function updateWithdrawStatus($dataArray, $id) {
        return DB::table('maintenance_fee')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function getdata($table, $column_nm, $id, $get_column) {
        $query = DB::table($table)->where($column_nm, $id)->get([$get_column]);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function insertData($table, $dataArray) {
        return DB::table($table)->insertGetId($dataArray);
    }

    public function updateStatus($table, $id, $status) {

        return DB::table($table)->where('id', $id)->update(['status' => $status]);
    }

    public function updateTableData($table, $updateArray, $where) {
        return DB::table($table)
                        ->where($where)
                        ->update($updateArray);
    }

    public function getComplaint() {

        return DB::table('complain')->Join('users', 'complain.user_id', '=', 'users.id')->orderBy('complain.create_date', 'desc')->get();
    }

    public function saveEmergencyContactData($array) {

        return DB::table('emergency-contact')->insert($array);
    }

    public function deletecontact($id) {

        return DB::table('emergency-contact')->where('id', $id)->delete();
    }

    public function actionChange($id, $status) {

        return DB::table('users')->where('id', $id)->update(['status' => $status]);
    }

    public function changeContactStatus($id, $status) {

        return DB::table('emergency-contact')->where('id', $id)->update(['status' => $status]);
    }

    public function familyActionChange($id, $status) {

        return DB::table('my-family')->where('id', $id)->update(['status' => $status]);
    }

    public function deletesubAdmin($id) {

        return DB::table('users')->where('id', $id)->delete();
    }

    public function get_propertyid($ptd_id) {

        return DB::table('property')->select('id')->where('ptd_id', $ptd_id)->first();
    }

   public function getMyFamily($ptd_id, $unit_id) {

        return DB::table('my-family')->Join('users', 'my-family.user_id', '=', 'users.id')->where('my-family.unit_id', $unit_id)->where('my-family.ptd_id', $ptd_id)->get(['users.nric', 'my-family.*']);
    }

  public function getFamilyMember($user_id, $unit_id) {
        $query = DB::table('my-family')
                ->Join('users', 'my-family.user_id', '=', 'users.id')
                ->where('my-family.user_id', $user_id)
                ->where('my-family.unit_id', $unit_id)
                ->where('my-family.type',  '=' ,  1)
                ->get(['my-family.*']);

        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getTenantDetails($user_id, $unit_id) {
        $query = DB::table('my-family')
                ->Join('users', 'my-family.user_id', '=', 'users.id')
                ->where('my-family.user_id', $user_id)
                ->where('my-family.unit_id', $unit_id)
                ->where('my-family.type',  '=' , 3)
                ->get(['my-family.*']);

        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

  public function getCarDetails($user_id, $unit_id) {
        $query = DB::table('my-family')
        ->Join('users', 'my-family.user_id', '=', 'users.id')
        ->where('my-family.unit_id', $unit_id)
        ->where('my-family.user_id', $user_id)
        ->where('my-family.type', '=' , 2)
        ->get(['my-family.*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getEcouponType() {
        $coupen_type = array('1' => 'Food', '2' => 'Product', '3' => 'Fashion', '4' => 'Electronic', '5' => 'Home&Living', '6' => 'Pet Shop');
        return $coupen_type;
    }

    public function getTransactionDetails($maintenance_id, $ptd_id) {
        $query = DB::table('maintenance_fee')
                ->leftJoin('transaction-detail', 'maintenance_fee.id', '=', 'transaction-detail.maintenance_id')
                ->join('users', 'maintenance_fee.user_id', '=', 'users.id')
                ->where('maintenance_fee.ptd_id', $ptd_id)
                ->where('maintenance_fee.id', $maintenance_id)
                ->orderBy('maintenance_fee.created_date', 'desc')
                ->get(['maintenance_fee.*', 'transaction-detail.transaction_id as transaction-detail_id', 'transaction-detail.slug', 'transaction-detail.bill_id', 'transaction-detail.created_date as transaction_date', 'users.name']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getMaintenanceFee($ptd_id, $user_id) {

        return DB::table('maintenance_fee')->where('user_id', $user_id)->where('ptd_id', $ptd_id)->orderBy('created_date', 'desc')->get();
    }

    public function deletemaintenancefee($id) {
        $delete_transaction = DB::table('transaction-detail')->where('maintenance_id', $id)->delete();
        return DB::table('maintenance_fee')->where('id', $id)->delete();
    }

    public function get_complaintByPtdId($property_id) {
             return DB::table('complain')
                ->Join('users', 'complain.user_id', '=', 'users.id')
                ->join('property_units', 'property_units.id', '=', 'complain.unit_id')
                ->where('complain.property_id', $property_id )
                ->select('property_units.*','complain.*', 'users.nric', 'users.mobile_number')
                ->orderBy('complain.create_date', 'DESC')
                ->get();
    }

    public function getMyVisitorByPtdId($property_id) {

        return DB::table('visitor_pass')
        ->Join('visitors', 'sender_id', '=', 'visitors.id')
        ->where('visitors.login_status', 1)
        ->where('visitor_pass.property_id', $property_id)
        ->orderBy('visitor_pass.created_date', 'DESC')->get();
    }

    public function getMyVisitorByPropertyId($property_id) {
        return DB::table('visitors')
                ->join('visitor_pass', 'visitors.cell_number', '=', 'visitor_pass.cell_number')
                ->where('visitor_pass.property_id', $property_id)
                ->where('visitors.login_status', 1)
                ->where('visitor_pass.invitation_status', 1)
                ->orderBy('visitor_pass.created_date', 'DESC')
                ->get();
    }

    public function todayMyVisitorByPtdId($ptd_id) {

        return DB::table('visitor_pass')->Join('visitors', 'visitor_pass.sender_id', '=', 'visitors.id')->where('visiting_date', 'like', date('Y-m-d') . '%')->where('visitors.login_status', 1)->where('ptd_id', $ptd_id)->orderBy('visitor_pass.created_date', 'DESC')->get();
    }

    public function getComplaintById($id) {

        return DB::table('complain')->where('id', $id)->first();
    }

    public function updateComplaint($dataArray, $id) {

        return DB::table('complain')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function updateVisitor($dataArray, $id) {

        return DB::table('visitor_pass')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function updateResidentuser($dataArray, $id) {

        return DB::table('users')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function deleteComplaint($id) {

        return DB::table('complain')->where('id', $id)->delete();
    }

    public function deletevisitor($id) {

        return DB::table('visitor_pass')->where('id', $id)->delete();
    }

  public function get_AnnounceNoticeByPtdId($property_id) {
        return DB::table('notice')->where('property_id', $property_id)->orderBy('create_date', 'desc')->get();
    }

    public function updateNotice($dataArray, $id) {

        return DB::table('notice')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function saveNotice($array) {

        return DB::table('notice')->insert($array);
    }

    public function getNoticeByPtdId($ptd_id, $property_id) {

        return DB::table('notice')->where('property_id', $property_id)->orderBy('notice.create_date', 'DESC')->get();
        ;
    }

    public function getNoticeById($id) {

        return DB::table('notice')->where('id', $id)->first();
    }

    public function deleteNotice($id) {

        return DB::table('notice')->where('id', $id)->delete();
    }

    public function get_InsuranceByPtdId($ptd_id) {

        return DB::table('insurance')->Join('users', 'insurance.user_id', '=', 'users.id')->where('insurance.ptd_id', $ptd_id)->orderBy('insurance.create_date', 'DESC')->get();
    }

    public function getHandymanByPtdId($ptd_id, $property_id) {
        return DB::table('handyman')->where('property_id', $property_id)->get();
    }

    public function getHandymanById($id) {
        return DB::table('handyman')->where('id', $id)->get();
    }

    public function get_HandymanContact($property_id) {

        return DB::table('handyman')->where('property_id', $property_id)->get();
    }

    public function saveHandymanContactData($array) {
        return DB::table('handyman')->insert($array);
    }

    public function updateHandymanData($dataArray, $id) {

        return DB::table('handyman')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function deleteHandymanContact($id) {

        return DB::table('handyman')->where('id', $id)->delete();
    }

    public function getCoupon($property_id) {

        return DB::table('e_coupon')->where('property_id', $property_id)->get();
    }

    public function saveCouponData($array) {

        return DB::table('e_coupon')->insert($array);
    }

    public function updateCouponData($dataArray, $id) {

        return DB::table('e_coupon')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function deleteCoupon($id) {

        return DB::table('e_coupon')->where('id', $id)->delete();
    }

    public function getCouponByPtdId($ptd_id, $property_id) {

        return DB::table('e_coupon')->where('property_id', $property_id)->get();
    }

    public function saveMaintenanceData($array) {
        $insert_id = DB::table('maintenance_fee')->insertGetId($array);
        $array = array('user_id' => $array['user_id'],
            'maintenance_id' => $insert_id,
            'amount' => null,
            'slug' => null,
            'status' => '0',
            'bill_id' => null
        );

        return DB::table('transaction-detail')->insert($array);
    }

    public function getMaintenanceFeesByDb($ptd_id) {

        return DB::table('maintenance_fee')->where('ptd_id', $ptd_id)->orderBy('created_date', 'DESC')->get();
    }

    public function getInsuranceByptdidAndUserId($ptd_id, $user_id) {

        return DB::table('insurance')->where('ptd_id', $ptd_id)->where('user_id', $user_id)->orderBy('create_date', 'DESC')->first();
    }

    public function updateMaintenanceData($dataArray, $id) {

        return DB::table('maintenance_fee')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function getMaintenanceFeesById($id) {
        $query = DB::table('maintenance_fee')
                ->join('transaction-detail', 'maintenance_fee.id', '=', 'transaction-detail.maintenance_id')
                ->where('maintenance_fee.id', $id)
                ->first();
        return $query;       
    }

    public function getInboxByPtdId($ptd_id, $user_id) {

        return DB::table('message')->where('ptd_id', $ptd_id)->where('reciever_id', $user_id)->where('a_delete_status', 0)->orderBy('date', 'DESC')->get();
    }

    public function getSentByPtdId($ptd_id, $user_id) {
        return DB::table('message')->where('ptd_id', $ptd_id)->where('sender_id', $user_id)->where('a_delete_status', 0)->orderBy('date', 'DESC')->get();
    }

    public function UpdateRcMcUser($dataArray, $id) {
        return DB::table('users')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function CheckMobileNumber($mobile_number) {
        return DB::table('users')->where('mobile_number', $mobile_number)->first();
    }


    public function getIdByNricAndMobile($nric , $mobile_number) {
        
        $result = DB::table('users')->where('nric', $nric)->where('mobile_number', $mobile_number)->first();
        if (count($result) > 0) {
            return $result->id;
        }
        return false;

    }
    
    public function CheckNricNumber($ptd_id, $nric, $cell_number, $unit_id, $type) { 
        $query1 = DB::table('users')->where('nric', $nric)->where('mobile_number', $cell_number)->first();
        $query2 = DB::table('users')->where('mobile_number', $cell_number)->get();
        $query3 = DB::table('users')->where('nric', $nric)->get();

        if (count($query1) > 0) {
            $query4 = DB::table('unit_user_relation')->where('user_id', $query1->id)->where('unit_id', $unit_id)->get();
            if (count($query4) > 0) {
                return 1;
            } else {
                if ($type == 2) {
                    $array = array(
                        'user_id' => $query1->id,
                        'property_id' => $ptd_id,
                        'unit_id' => $unit_id
                    );

                    return DB::table('unit_user_relation')->insert($array);
                }
            }
        } else if (count($query2) > 0) {
            return 2;
        } else if (count($query3) > 0) {
            return 3;
        }
    }

    public function CheckNricNumberExist($ptd_id, $nric, $cell_number, $unit_id, $type) { 
        $query1 = DB::table('users')->where('nric', $nric)->where('mobile_number', $cell_number)->first();
        
        //$query2 = DB::table('users')->where('mobile_number', $cell_number)->where('mobile_number', $cell_number)->get();
        $query2 = DB::table('users')
                    ->join('unit_user_relation', 'users.id', '=', 'unit_user_relation.user_id')
                    //->where('users.nric', $nric)
                    ->where('users.mobile_number', $cell_number)
                    ->where('unit_user_relation.unit_id', $unit_id)
                    ->get();

        //$query3 = DB::table('users')->where('nric', $nric)->get();
        $query3 =  DB::table('users')
                    ->join('unit_user_relation', 'users.id', '=', 'unit_user_relation.user_id')
                    ->where('users.nric', $nric)
                    // ->where('users.mobile_number', $cell_number)
                    ->where('unit_user_relation.unit_id', $unit_id)
                    ->get();

        if (count($query1) > 0) {
            $query4 = DB::table('unit_user_relation')->where('user_id', $query1->id)->where('unit_id', $unit_id)->get();
            if (count($query4) > 0) {
                return 1;
            } else {
                if ($type == 2) {
                    $array = array(
                        'user_id' => $query1->id,
                        'property_id' => $ptd_id,
                        'unit_id' => $unit_id
                    );

                    return DB::table('unit_user_relation')->insert($array);
                }
            }
        } else if (count($query2) > 0) {
            return 2;
        } else if (count($query3) > 0) {
            return 3;
        }
    }

    public function getUserMaintenanceFeesByDb($ptd_id, $unit_id, $property_id) {
        return DB::table('maintenance_fee')->where('unit_id', $unit_id)->orderBy('maintenance_fee.created_date', 'DESC')->get();
    }

    public function getAllUnits($ptd_id) {
        return DB::table('property_units')->where('ptd_id', $ptd_id)->orderBy('property_units.created_date', 'DESC')->get();
    }

    // public function checkMaintenance($maintenance_id, $user_id) {
    //     return DB::table('transaction-detail')->where('maintenance_id', $maintenance_id)->where('user_id', $user_id)->first();
    // }

    public function savetransactionDetail($user_id, $maintenance_id, $amount, $slug, $status, $bill_id) {
        if ($status == 'success') {
            $status_type = '1';
            $dataArray = array('payment_status' => $status_type,
                'user_id' => $user_id,
            );
            $variable = DB::table('maintenance_fee')
                    ->where('id', $maintenance_id)
                    ->update($dataArray);
        } else {
            $status_type = '0';
            $dataArray = array('payment_status' => '2',
                'user_id' => $user_id,
            );
            $variable = DB::table('maintenance_fee')
                    ->where('id', $maintenance_id)
                    ->update($dataArray);
        }

        $array = array(
            'amount' => $amount,
            'slug' => $slug,
            'status' => $status_type,
            'bill_id' => $bill_id,
            'user_id' => $user_id
        );

        return DB::table('transaction-detail')->where('maintenance_id', $maintenance_id)->update($array);
        // return DB::table('transaction-detail')->insertGetId($array);
    }

    public function gettransactiondetail($transaction_id) {
        return DB::table('transaction-detail')->where('transaction_id', $transaction_id)->first();
    }

    public function getCouponDetailById($id) {
        return DB::table('e_coupon')->where('id', $id)->get();
    }

    public function getUnitById($id) {
        return DB::table('property_units')->where('id', $id)->first();
    }

    public function getMaintenancedetail($ptd_id, $unit_id) {

        $query = DB::table('maintenance_fee')
                ->join('transaction-detail', 'maintenance_fee.id', '=', 'transaction-detail.maintenance_id')
                //->where('maintenance_fee.ptd_id', $ptd_id)
                ->where('maintenance_fee.unit_id', $unit_id)
                ->get();
        return $query;

        //return DB::table('property_units')->where('id', $id)->first();
    }
   
    
    public function deleteRow($table,$array){
             return DB::table($table)->where($array)->delete();
     }
    
    public function getInActiveUnitRelation($user_id){
       $query= DB::table('unit_user_relation')->where('user_id',$user_id)->where('status',2)->get(['unit_id']);
        if ($query->isEmpty()) { 
            return false;
        } else {
            return $query;
        }
    } 


    public function checkUserUnitRelation($user_id , $property_id, $unit_id){
         $query = DB::table('unit_user_relation')->where('user_id', $user_id)->where('property_id' , $property_id)->where('unit_id' , $unit_id)->get(['id']);
        if ($query->isEmpty()) { 
            return false;
        } else {
            return true;
        }
    } 
    
  public function getActiveUnit($unit_id_array,$property_id){
     $query= DB::table('property_units')
     ->whereNotIn('id',$unit_id_array)
     ->where('property_id',$property_id)->get();
        if ($query->isEmpty()) { 
            return false;
        } else {
            return $query;
        }  
    }
    

   public function getActiveUnits($property_id){
        $query = DB::table('property_units')   
        ->where('property_id', $property_id)
        ->where('status', '!=' , 2)->get();
            if ($query->isEmpty()) { 
                return false;
            } else {
                return $query;
            }  
    }
    
     public function getWhere($table,$where){
      $query = DB::table($table)->where($where)->get(['*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }   
    }

    public function getResult($table){
      $query = DB::table($table)->get(['*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        } 
    }


    public function getResultWhereNot($id,$username){
        $query = DB::table("security_guard")
                ->where('username',$username)
                ->where('security_id', '!=' ,$id )
                ->get(['*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }    
    }

    public function getAccount($property_id){
      $query = DB::table('property_accounts')   
        ->where('property_id', $property_id)->get();
        if ($query->isEmpty()) { 
            return false;
        } else {
            return $query;
        }  
    }

    public function getAccountTransaction($property_id){
       return DB::table('property')
                ->Join('property_units',[['property.id','=','property_units.property_id']])
                ->Join('maintenance_fee',[['property_units.id','=','maintenance_fee.unit_id']])   
                ->Join('transaction-detail',[['maintenance_fee.id','=','transaction-detail.maintenance_id']])  
                ->where('property.id', '=', $property_id)
                ->where('maintenance_fee.payment_status', '!=', '0')
                ->where('maintenance_fee.withdraw_status', '=', '0')
                ->get(['maintenance_fee.id as maintenance_fee_id', 'transaction-detail.updated_at as transaction_date', 'transaction-detail.bill_id', 'transaction-detail.slug', 'maintenance_fee.amount', 'maintenance_fee.item_list', 'maintenance_fee.tax_percentage', 'maintenance_fee.tax_amount', 'maintenance_fee.total_amount', 'maintenance_fee.invoice_month', 'maintenance_fee.payment_status', 'maintenance_fee.withdraw_status', 'property_units.unit_ptd', 'property_units.block_number', 'property_units.unit_number', 'property_units.address', 'property.ptd_id', 'property.user_id', 'property.country', 'property.country', 'property.township_name']);
    }

    public function addWithdrawal($array) {
        return DB::table('withdrawal_detail')->insert($array);
    }

    public function addSetting($array) {
        return DB::table('setting')->insert($array);
    }

    public function insertCountData($array) {
        return DB::table('page_view_count')->insert($array);
    }

    public function getCount($id, $type){
        $view_data = DB::table('page_view_count')->where('page_id', $id)->where('type', $type)->get();
        return count($view_data);
    }

    public function getUsersbyPropertyId($property_id){
        return DB::table('users')
            ->Join('unit_user_relation',[['users.id','=','unit_user_relation.user_id']])
            ->where('unit_user_relation.property_id', $property_id)
            ->get();
    }

    public function getPendingMaintenance($ptd_id, $unit_id){

        return DB::table('maintenance_fee')
            ->Join('unit_user_relation',[['maintenance_fee.unit_id','=','unit_user_relation.unit_id']])
            ->Join('users',[['unit_user_relation.user_id','=','users.id']]) 
            ->where('maintenance_fee.unit_id', $unit_id)
            ->where('payment_status', 0)
            ->get(['users.mobile_number','maintenance_fee.invoice_month','maintenance_fee.invoice_date','maintenance_fee.total_amount']);
    }

    public function removeTeman($array, $id){
        return DB::table('users')->where('id', $id)->update($array);
    }

    public function deleteTeman($id){
        return DB::table('users')->where('id', $id)->delete();
    }

}
