<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    public function supportTypes()
    {
        return $this->hasMany('App\SupportType', 'service_type_id', 'id');
    }
}
