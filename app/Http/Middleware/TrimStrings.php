<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
        'number_thousandsseparator',
        'amount_thousandsseparator',
        'number_decimalseparator',
        'amount_decimalseparator'
    ];
}
