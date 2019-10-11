<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $hidden = [
        'driver_compliance_code',
        'passenger_compliance_code',
    ];

    public function getDepartureTimeAttribute($value)
    {
        $value = new Carbon($value);
        return $value->format('h:i A');
    }
}
