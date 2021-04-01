<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerExtraData extends Model
{
    protected $table = 'customers_registrations_extra_data';

    protected $fillable = [
        'user_id',
        'job_id',
        'stripe_customer_id'
    ];
}
