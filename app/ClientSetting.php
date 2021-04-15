<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientSetting extends Model
{
    protected $table = 'client_setting';

    protected $fillable = [
        'name',
        'the_value',
        'client_id'
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
