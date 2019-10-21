<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    /**
     * Table associated with this model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Booting method and add global scope for this model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AdminScope);
    }
}
