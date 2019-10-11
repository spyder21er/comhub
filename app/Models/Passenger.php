<?php

namespace App\Models;

use App\Scopes\PassengerScope;

class Passenger extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PassengerScope);
    }
}
