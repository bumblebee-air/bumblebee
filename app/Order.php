<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
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
        'status',
        'weight',
        'dimensions',
        'customer_confirmation_code',
        'delivery_confirmation_code',
        'delivery_confirmation_status',
        'delivery_confirmation_skip_reason',
        'retailer_id',
        'is_archived',
        'is_paidout_retailer',
        'is_paidout_driver'
    ];

    public function orderDriver() {
        return $this->belongsTo(User::class, 'driver');
    }

    public function retailer() {
        return $this->belongsTo(Retailer::class, 'retailer_id');
    }

    public function orderTimestamps() {
        return $this->hasOne(KPITimestamp::class, 'model_id');
    }

    public function comments() {
        return $this->morphMany(JobComment::class, 'job', 'job_model', 'job_id', 'id');
    }

    public function rating() {
        return $this->hasOne(Rating::class, 'model_id');
    }
}
