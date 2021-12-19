<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    protected $dates = ['last_active'];
    protected $appends = ['last_active_web', 'overall_rating'];
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
        return $this->last_active ? $this->last_active->format('d-m-Y h:i A') : '';
    }
    public function getOverallRatingAttribute()
    {
        $order_ids = $this->user->orders->pluck('id')->toArray();
        $driver_ratings = \DB::table('ratings')->where('model', '=', 'order')
            ->whereIn('model_id', $order_ids)->selectRaw('avg(rating) as average_rating')->first();
        $driver_overall_rating = ($driver_ratings->average_rating != null) ? $driver_ratings->average_rating : 0;
        return $overall_rating = round($driver_overall_rating * 2) / 2;
    }
}
