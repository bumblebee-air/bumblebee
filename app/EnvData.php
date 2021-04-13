<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnvData extends Model
{
    protected $table = 'env_data';

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
