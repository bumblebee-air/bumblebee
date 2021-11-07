<?php

namespace Modules\DoOrder\Driver\Entities;

use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payouts() {
        return $this->hasMany(DriverPayout::class, 'driver_id');
    }
}
