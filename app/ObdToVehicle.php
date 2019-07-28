<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObdToVehicle extends Model
{
    protected $table = 'obd_to_vehicle';

    public function vehicle(){
        return $this->hasOne('App\Vehicle','id','vehicle_id');
    }

    public function obd(){
        return $this->hasOne('App\OBD','id','obd_id');
    }
}
