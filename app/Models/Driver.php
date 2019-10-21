<?php

namespace App\Models;

use App\Scopes\DriverScope;

class Driver extends User
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

        static::addGlobalScope(new DriverScope);
    }

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Administrator of this driver.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
