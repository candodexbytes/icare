<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model {

    public function get_subAdmin($ptd_id) {

        return DB::table('users')->where('ptd_id', $ptd_id)->whereBetween('type', [5, 6])->orderBy('created_at', 'desc')->get();
    }

    public function getUserByPtdId($ptd_id) {

        return DB::table('users')->where('ptd_id', $ptd_id)->whereBetween('type', [1, 2])->orderBy('created_at', 'desc')->get();
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

    public function get_lastptd() {

        return $query = DB::table('property_units')->orderBy('id', 'desc')->first();
    }

    public function saveData($array) {

        return DB::table('property')->insert($array);
    }

    public function get_emergencyContact($ptd_id) {

        return DB::table('emergency-contact')->where('ptd_id', $ptd_id)->get();
    }

    public function getPropertyUnit($ptd_id_genrate) {
        $query = DB::table('property_units')->where('ptd_id', $ptd_id_genrate)->get();
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

    public function getMyFamily($ptd_id, $user_id) {

        return DB::table('my-family')->Join('users', 'my-family.user_id', '=', 'users.id')->where('user_id', $user_id)->where('my-family.ptd_id', $ptd_id)->get(['users.nric', 'my-family.*']);
    }

    public function getFamilyMember($ptd_id, $user_id) {

        $query = DB::table('my-family')->Join('users', 'my-family.user_id', '=', 'users.id')->where('user_id', $user_id)->where('my-family.ptd_id', $ptd_id)->where('my-family.type', 1)->get(['users.nric', 'my-family.*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getTenantDetails($ptd_id, $user_id) {
        $query = DB::table('my-family')->Join('users', 'my-family.user_id', '=', 'users.id')->where('user_id', $user_id)->where('my-family.ptd_id', $ptd_id)->where('my-family.type', 2)->get(['users.nric', 'my-family.*']);
        if ($query->isEmpty()) {
            return false;
        } else {
            return $query;
        }
    }

    public function getCarDetails($ptd_id, $user_id) {
        $query = DB::table('my-family')->Join('users', 'my-family.user_id', '=', 'users.id')->where('user_id', $user_id)->where('my-family.ptd_id', $ptd_id)->where('my-family.type', '!=', [1, 2])->get(['users.nric', 'my-family.*']);
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

    public function get_complaintByPtdId($ptd_id) {
        return DB::table('complain')->Join('users', 'complain.user_id', '=', 'users.id')->where('complain.ptd_id', $ptd_id)->select('complain.*', 'users.nric', 'users.mobile_number')->orderBy('complain.create_date', 'DESC')->get();
    }

    public function getMyVisitorByPtdId($ptd_id) {

        return DB::table('visitor_pass')->Join('visitors', 'sender_id', '=', 'visitors.id')->where('visitors.login_status', 1)->where('ptd_id', $ptd_id)->orderBy('visitor_pass.created_date', 'DESC')->get();
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

    public function get_AnnounceNoticeByPtdId($ptd_id) {
        return DB::table('notice')->where('ptd_id', $ptd_id)->orderBy('create_date', 'desc')->get();
    }

    public function updateNotice($dataArray, $id) {

        return DB::table('notice')
                        ->where('id', $id)
                        ->update($dataArray);
    }

    public function saveNotice($array) {

        return DB::table('notice')->insert($array);
    }

    public function getNoticeByPtdId($ptd_id) {

        return DB::table('notice')->where('ptd_id', $ptd_id)->orderBy('notice.create_date', 'DESC')->get();
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

    public function getHandymanByPtdId($ptd_id) {
        return DB::table('handyman')->where('ptd_id', $ptd_id)->get();
    }

    public function getHandymanById($id) {
        return DB::table('handyman')->where('id', $id)->get();
    }

    public function get_HandymanContact($ptd_id) {

        return DB::table('handyman')->where('ptd_id', $ptd_id)->get();
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

    public function getCoupon($ptd_id) {

        return DB::table('e_coupon')->where('ptd_id', $ptd_id)->get();
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

    public function getCouponByPtdId($ptd_id) {

        return DB::table('e_coupon')->where('ptd_id', $ptd_id)->get();
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
                ->get();
        return $query;
        // return DB::table('maintenance_fee')->where('id', $id)->get();
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

    public function getUserMaintenanceFeesByDb($ptd_id, $user_id) {
        return DB::table('maintenance_fee')->where('ptd_id', $ptd_id)->where('user_id', $user_id)->orderBy('maintenance_fee.created_date', 'DESC')->get();
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
            $dataArray = array('payment_status' => $status_type);
            $variable = DB::table('maintenance_fee')
                    ->where('id', $maintenance_id)
                    ->update($dataArray);
        } else {
            $status_type = '0';
            $dataArray = array('payment_status' => '2');
            $variable = DB::table('maintenance_fee')
                    ->where('id', $maintenance_id)
                    ->update($dataArray);
        }

        $array = array(
            'amount' => $amount,
            'slug' => $slug,
            'status' => $status_type,
            'bill_id' => $bill_id
        );

        return DB::table('transaction-detail')->where('maintenance_id', $maintenance_id)->where('user_id', $user_id)->update($array);
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

    public function saveInvoiceData($ptd_id, $unit_id, $invoiceDate , $paymentDate, $item) {

        $array = array(
            'ptd_id' => $ptd_id,
            'unit_id' => $unit_id,
            'item_list' => $item

        );

        return DB::table('maintenance_fee')->insert($array);
    }

}
