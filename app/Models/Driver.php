<?php

namespace App\Models;

use App\Scopes\DriverScope;

class Driver extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new DriverScope);
    }
}
