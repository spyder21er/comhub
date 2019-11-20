<?php

namespace App\Models;

use App\Models\Traits\PersonTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Driver extends Model
{
    use PersonTrait;

    protected $guarded = [];

    protected $dates = ['penalty_lifted_at'];

    /**
     * License expiry date mutator
     */
    public function setLicenseExpiryAttribute($value)
    {
        $this->attributes['license_expiry'] = (new Carbon($value));
    }

    /**
     * License expiry date accessor
     */
    public function getLicenseExpiryAttribute()
    {
        return (new Carbon($this->attributes['license_expiry']))->format('M d, Y');
    }

    /**
     * Trips fetched by this driver
     */
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

    /**
     * Total number of trips hailed by this driver.
     */
    public function hailedTrips()
    {
        return $this->trips->count();
    }

    /**
     * Total number of confirmed trips
     */
    public function confirmedTrips()
    {
        return $this->trips->filter(function ($trip) {
            return $trip->driver_complied;
        })->count();
    }

    /**
     * Total number of unconfirmed trips
     */
    public function unconfirmedTrips()
    {
        return $this->hailedTrips() - $this->confirmedTrips();
    }

    /**
     * Ratio of confirmed trips to total trips hailed.
     */
    public function credibilityPoints()
    {
        if ($this->hailedTrips() == 0)
            return "None";

        return $this->confirmedTrips() / $this->hailedTrips() * 100;
    }

    /**
     * Organization of this driver
     */
    public function getOrganizationAttribute()
    {
        return $this->admin->org_acronym;
    }

    /**
     * Scope to filter drivers that belongs to a particular town
     */
    public function scopeWhereTown($query, $town_id)
    {
        return $query->whereHas('user', function ($q) use ($town_id) {
            $q->where('town_id', $town_id);
        });
    }

    /**
     * Determine whether this driver can fetch trips
     */
    public function canFetch()
    {
        return Str::lower($this->status) == 'active';
    }

    /**
     * Determine if this driver has trip today
     */
    public function hasTripToday()
    {
        return $this->trips()->today()->get()->isNotEmpty();
    }

    public function getStatusAttribute($value)
    {
        return Str::title($value);
    }

    /**
     * Determine if this driver can pick up trips
     */
    public function cannotPickUpTrips()
    {
        return $this->isBanned() || $this->isSuspended();
    }

    /**
     * Determine if this driver can is banned
     */
    public function isBanned()
    {
        return $this->status == "Banned";
    }

    /**
     * Determine if this driver can is suspended
     */
    public function isSuspended()
    {
        return $this->status == "Suspended";
    }

    /**
     * Lift the suspension of this driver if already expired.
     */
    public function liftSuspensionIfExpired()
    {
        if ($this->suspensionExpired()) {
            if (Str::lower($this->status) != 'active')
            {
                $this->status = 'active';
                $this->save();
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the suspension of this driver is already expired.
     */
    public function suspensionExpired()
    {
        $now = Carbon::now();
        if ($this->penalty_lifted_at) {
            if ($this->penalty_lifted_at->lessThanOrEqualTo($now)) {
                return true;
            }
        }
        return false;
    }
}
