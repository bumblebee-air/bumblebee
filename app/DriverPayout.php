<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverPayout extends Model
{
    protected $table = 'drivers_payout_history';

    protected $fillable = [
        'driver_id',
        'transaction_id',
        'orders_ids',
        'subtotal',
        'original_subtotal',
        'charged_amount',
        'additional',
        'notes',
    ];

    protected $casts = [
        'orders_ids' => 'array'
    ];
}
