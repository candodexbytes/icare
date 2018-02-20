<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Nexmo;

class Push extends Model
{	

	protected $api_username = "dexbytes_condo";
	protected $api_password = "dexbytes_condo";
	protected $api_url      = "http://app.intentapp.in/pushapi/sender/send";
	protected $app_id      = "2";

	public function send($data){
        $data["app_id"] = $this->app_id;
        $credentials = $this->api_username.":".$this->api_password;
        $request = curl_init();
        # Setting options
        curl_setopt($request, CURLOPT_URL, $this->api_url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_TIMEOUT, 3);
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($request, CURLOPT_USERPWD, $credentials);
        # Query string
        $query_string = http_build_query($data);
        curl_setopt($request, CURLOPT_POSTFIELDS, $query_string);
        # Call
        $result = curl_exec($request);        
        $status_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
        # Closing connection
        curl_close($request);

       return $result;
    }

    public function sendOtp($mobile_number, $message){
        try {
              $nexmo = app('Nexmo\Client');
              $country_phone_code = $this->getMobileCountryCode($mobile_number);
              if(!$country_phone_code){
                  $country_phone_code = '60';
              }

              $obj = Nexmo::message()->send([
                  'to'   => $country_phone_code.''.$mobile_number,
                  'from' => "Dexbytes",
                  'text' => $message
              ]);
            } catch (Exception $e) {
                report($e);
                return false;
            }

            if($obj['messages'][0]['status'] > 0 ){
              return false;
            }else{
              return true;
            }
           
    }

    public function sendVisitorOtp($mobile_number, $country_code, $message){
        try {

              $nexmo = app('Nexmo\Client');
              
              $obj = Nexmo::message()->send([
                  'to'   => $country_code.''.$mobile_number,
                  'from' => "Dexbytes",
                  'text' => $message
              ]);

            } catch (Exception $e) {
                report($e);
                return false;
            }

            if($obj['messages'][0]['status'] > 0 ){
              return false;
            }else{
              return true;
            }
           
    }

    public function getMobileCountryCode($mobile_number){
            $query = DB::table('unit_user_relation') 
                ->Join('users',[['unit_user_relation.user_id','=','users.id']])
                ->Join('property',[['property.id','=','unit_user_relation.property_id']])
                ->where('users.mobile_number', $mobile_number)          
                ->get(['property.country_phone_code'])->first();
            if (!isset($query->country_phone_code)) {
                  $query2 = DB::table('visiting_card')             
                      ->Join('property',[['property.id','=','visiting_card.property_id']])
                      ->where('visiting_card.visitor_mobile_number', $mobile_number)          
                      ->get(['property.country_phone_code'])->first();
                      if (isset($query2->country_phone_code)) {
                         return $query2->country_phone_code;   
                      }else{                  
                        return false;
                      }
            }else{
               return $query->country_phone_code;     
            }
      }

}