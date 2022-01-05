<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProperty extends Model
{
    protected $table = 'customers_registrations_properties';

    protected $fillable = [
        'work_location',
        'type_of_work',
        'location',
        'location_coordinates',
        'property_size',
        'site_details',
        'is_parking_access',
        'area_coordinates',
        'services_types_json',
        'user_id',
        'property_photo',
    ];

    protected $casts = [
        'location_coordinates' => 'array',
        'area_coordinates' => 'array',
        'services_types_json' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
