<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers_registrations';

    protected $fillable = [
        'status',
        'contractor_id'
    ];

    protected $casts = [
        'job_image' => 'array',
    ];

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
}
