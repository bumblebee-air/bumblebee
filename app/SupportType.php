<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'service_type_id'];

    public function serviceType()
    {
        return $this->belongsTo('App\ServiceType', 'service_type_id', 'id');
    }
}
