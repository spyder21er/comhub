<?php

namespace App\Models;

use App\Scopes\PassengerScope;

class Passenger extends User
{
    /**
     * The table associated with this model.
     */
    protected $table = 'users';

    /**
     * Booting method and add global scope for this model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PassengerScope);
    }
}
