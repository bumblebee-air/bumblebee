<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'order_id',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_address_lat',
        'customer_address_lon',
        'eircode',
        'pickup_address',
        'pickup_lat',
        'pickup_lon',
        'fulfilment',
        'notes',
        'deliver_by',
        'fragile',
        'retailer_name',
        'status'
    ];

    public function orderDriver() {
        return $this->belongsTo(User::class, 'driver');
    }
}
