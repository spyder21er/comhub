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
     * User model associated with this administrator
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine if this admin has associated drivers
     */
    public function hasDrivers()
    {
        return $this->drivers->isNotEmpty();
    }

    /**
     * Determine if this admin has some drivers that can fetch
     */
    public function hasDriversThatCanFetch()
    {
        if ($this->hasDrivers())
            return $this->drivers->filter(function($d) {
                return $d->canFetch();
            })->isNotEmpty();
        return false;
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
