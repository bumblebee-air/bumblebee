<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoomYogaCustomerEvent extends Model
{
    protected $table = 'doom_yoga_customers_events';

    protected $fillable = [
        'customer_id',
        'event_id'
    ];
}
