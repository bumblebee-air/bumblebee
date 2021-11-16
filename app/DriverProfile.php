<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    protected $dates = ['last_active'];
    protected $appends = ['last_active_web'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payouts()
    {
        return $this->hasMany(DriverPayout::class, 'driver_id');
    }

    public function getLastActiveWebAttribute()
    {
        return $this->last_active ? $this->last_active->format('d-m-Y h:i A'): '';
    }
}
