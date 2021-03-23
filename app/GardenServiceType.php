<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GardenServiceType extends Model
{
    protected $table = 'garden_services_types';

    protected $fillable = [
        'name',
        'min_hours',
        'is_service_recurring',
        'rate_property_sizes',
    ];
}
