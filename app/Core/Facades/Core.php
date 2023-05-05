<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|\Illuminate\Contracts\Auth\Factory auth(string $guard)
 * @method static \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory view($view = null, $data = [], $mergeData = [])
 * @method string detectGuard()
 *
 * @see \App\Core\Core
 */

class Core extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'core';
    }
}