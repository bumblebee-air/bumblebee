<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    protected $table = 'customers_registrations';

    protected $fillable = [
        'status',
        'contractor_id',
        'property_photo'
    ];

    protected $casts = [
        'job_image' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        Customer::creating(function($model) {
            $model->customer_confirmation_code = Str::random(10);
            $model->contractor_confirmation_code = Str::random(10);
        });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stripe_customer() {
        return $this->hasOne(CustomerExtraData::class, 'job_id');
    }

    public function contractor() {
        return $this->belongsTo(User::class, 'contractor_id')->withTrashed();
    }

    public function kpi_timestamps() {
        return $this->morphOne(KPITimestamp::class, 'model', 'model_id');
    }

    public function job_timestamps() {
        return $this->morphMany(JobTimestamp::class, 'model');
    }

    public  function contractors_bidding() {
        return $this->hasMany(ContractorBidding::class, 'job_id');
    }
}
