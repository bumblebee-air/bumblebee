<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function setting() {
        return $this->hasMany(ClientSetting::class, 'client_id');
    }
}
