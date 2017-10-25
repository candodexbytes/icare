<?php

namespace App\Http\Controllers;

use App\API\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
    	//$this->middleware('auth:api');
    }

    protected function allowedAdminAction()
    {
    	if (Gate::denies('admin-action')) {
            throw new AuthorizationException('This action is unauthorized');
        }
    }
}