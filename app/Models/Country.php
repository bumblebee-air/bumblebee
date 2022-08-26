<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = ['id'];

    /**
     * Get all cities that belong to this country
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get all states of the country
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
