<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Property;
use Closure;
use Session;
use Auth;
use DB;

class CheckSessionProperty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    if(Auth::user() && !Session::has('Property')){
     $User = Auth::user();  
     $userType = $User->type;
     $Property = new Property;
     if($userType==5 || $userType==6){
      $property_id = $User->property_id;
      $Property = $Property->getPropertyById($property_id);     
      Session::put('Property', $Property);
     
     }
         
    }
      return $next($request);
    }
}
