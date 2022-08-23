<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    protected $guarded = ['id'];

    /**
     * Get all cities that belongs to this country
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
