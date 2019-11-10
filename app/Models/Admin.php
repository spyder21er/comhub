<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * Drivers under this administrator.
     */
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    /**
     * Home town of this admin
     */
    public function town()
    {
        return $this->hasOneThrough(Town::class, User::class, 'id', 'id', 'user_id', 'town_id');
    }

    /**
     * Associated user account of this driver
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
