<?php

namespace App\Models;

use App\Scopes\AdminScope;

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

    /**
     * Drivers under this administrator.
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
