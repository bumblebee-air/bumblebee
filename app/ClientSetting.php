<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientSetting extends Model
{
    protected $fillable = [
        'name', 'the_value', 'client_id', 'display_name'
    ];
}
