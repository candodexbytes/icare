<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/admin/addNewUnitUser',
        '/admin/save-withdrawal',
        '/admin/save-setting',
        '/admin/reminder',
        '/admin/remove-teman-from-management',
        '/admin/delete-teman'
    ];
}
