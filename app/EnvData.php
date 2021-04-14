<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnvData extends Model
{
    protected $table = 'env_data';

    protected $fillable = [
        'client_id',
        'key',
        'value'
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
