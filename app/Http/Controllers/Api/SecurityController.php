<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Login;
use App\Models\Push;
use App\Models\Security;

class SecurityController extends Controller{

	public function securityLogin(Request $request){ 
        $postData = $request->all();
        $errors = array();

        if(empty($postData['username'])) $errors[] = "username";
        if(empty($postData['password'])) $errors[] = "password ";    

        if(!empty($errors)) {
            $message = array("Please sent in the following fields:");
            foreach($errors as $error) {
                $message[] = $error;
            }
            $message = join(',', $message);
            return response()->json(['response' => false , 
                'message' =>  $message              
            ]);
        }


        $Security_obj = new Security;
        $Push_obj = new Push;

        $username = $postData['username'];
        $password = md5($postData['password']);
        	
       $data = $Security_obj->checkSecurityLogin($username, $password);

       if (count($data) > 0) {
       		return response()->json(['response'=> true, 'message' => 'Login successfully!','data' => $data]);
       }

       return response()->json(['response'=> false, 'message' => 'Invalid Credentials , Please try again.']);

    }

    public function securityUserDetail(Request $request){ 
        $postData = $request->all();
        $errors = array();

        if(empty($postData['security_id'])) $errors[] = "security_id"; 

        if(!empty($errors)) {
            $message = array("Please sent in the following fields:");
            foreach($errors as $error) {
                $message[] = $error;
            }
            $message = join(',', $message);
            return response()->json(['response' => false , 
                'message' =>  $message              
            ]);
        }

        $Security_obj = new Security;
        $security_id = $postData['security_id'];
        
        $data = $Security_obj->securityUser($security_id);
        
        if (count($data) > 0) {
            return response()->json(['response'=> true,'data' => $data]);
        }

        return response()->json(['response'=> false]);
    }

    public function securityPasses(Request $request){ 
        $postData = $request->all();
        $errors = array();

        if(empty($postData['property_id'])) $errors[] = "property_id"; 

        if(!empty($errors)) {
            $message = array("Please sent in the following fields:");
            foreach($errors as $error) {
                $message[] = $error;
            }
            $message = join(',', $message);
            return response()->json(['response' => false , 
                'message' =>  $message              
            ]);
        }

        $Security_obj = new Security;
        $property_id = $postData['property_id'];
        
        $data = $Security_obj->securityPasses($property_id);
        
        if (count($data) > 0) {
            return response()->json(['response'=> true,'data' => $data]);
        }

        return response()->json(['response'=> false]);
    }

}



?>