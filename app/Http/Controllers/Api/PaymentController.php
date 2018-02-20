<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Twilio;
use Kidino\Billplz\Billplz;

class PaymentController extends Controller{
    
    public function index(Request $request ){
    	$token = base64_encode('payment-token');
        echo $token;die();
       
    	return response()->json(['response'=>'1']);
    }

	public function store(Request $request){
        

        $url = 'https://billplz-staging.herokuapp.com/api/v2/bills';
        $ch = curl_init($url);
        $fields = array(
                    'collection_id' => 'kvxuid40',
                    'email' => 'example@mailinator.com',
                    'name' => 'Johnathan',
                    'amount' => '100',
                    'mobile' => '+60123456789',
                    'callback_url' => 'http://api.dexbytes.in/condo-management/',
                    //if true, a SMS will be send to the mobile with a charge of 50 cents
                    'deliver' => 'false'
                );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_USERPWD, "323d17f7-6fa7-45b0-92a1-ce6b39c0f4d5");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            //execute post
            $result = curl_exec($ch);

            if ($result === true) 
            {
                $info = curl_getinfo($ch);
                curl_close($ch);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            print_r($result);
        //close connection
        curl_close($ch);
            die('asd');
       
       
    	return response()->json(['response'=>'0']);
    }
    
}
