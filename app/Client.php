<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function main_services() {
        return $this->hasMany(ClientsMainService::class, 'client_id');
    }
}
