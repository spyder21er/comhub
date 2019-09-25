<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $hidden = [
        'driver_compliance_code',
        'passenger_compliance_code',
    ];
}
