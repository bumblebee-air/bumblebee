<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $table = 'contractors_registrations';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'experience_level',
        'experience_level_value',
        'age_proof',
        'type_of_work_exp',
        'address',
        'company_number',
        'vat_number',
        'insurance_document',
        'has_smartphone',
        'type_of_transport',
        'charge_type',
        'charge_rate',
        'has_callout_fee',
        'callout_fee_value',
        'rate_of_green_waste',
        'green_waste_collection_method',
        'social_profile',
        'website_address',
        'cv',
        'job_reference',
        'available_equipments'
    ];
}
