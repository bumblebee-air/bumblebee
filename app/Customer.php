<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers_registrations';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stripe_customer() {
        return $this->hasOne(CustomerExtraData::class, 'job_id');
    }

    public function main_service() {
        $this->morphOne(ClientsMainService::class, 'service');
    }
}
