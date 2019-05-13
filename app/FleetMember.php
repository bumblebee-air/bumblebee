<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FleetMember extends Model
{
    public function the_user(){
        return $this->hasOne('App\User','id','user_id');
    }
}
