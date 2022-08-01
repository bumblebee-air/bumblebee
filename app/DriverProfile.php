<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverProfile extends Model
{
    use SoftDeletes;

    protected $dates = ['last_active', 'last_assigned'];
    protected $appends = ['last_active_web', 'last_assigned_web', 'overall_rating'];

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
        return $this->last_active ? $this->last_active->format('d-m-y H:i') : '';
    }

    public function getLastAssignedWebAttribute()
    {
        return $this->last_assigned ? $this->last_assigned->format('d-m-y H:i') : '';
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
