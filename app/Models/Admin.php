<?php

namespace App\Models;

use App\Models\Traits\PersonTrait;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use PersonTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['org_acronym', 'org_name'];

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
     * Determine if this admin has associated drivers
     */
    public function hasDrivers()
    {
        return $this->drivers->isNotEmpty();
    }

    /**
     * Get the account status of this admin
     */
    public function getAccountStatusAttribute()
    {
        return ($this->active) ? 'Active' : 'Deactivated';
    }

    /**
     * Get the button name for changing account status
     */
    public function getChangeStatusCommandAttribute()
    {
        return ($this->active) ? 'Deactivate' : 'Activate';
    }

    /**
     * Get the button style for changing account status
     */
    public function getButtonStyleAttribute()
    {
        return ($this->active) ? 'success' : 'danger';
    }

    /**
     * Get the number of drivers under this admin
     */
    public function getDriversCountAttribute()
    {
        return $this->drivers->count();
    }
}
