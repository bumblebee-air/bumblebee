<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomNotification extends Model
{
    protected $table = 'custom_notifications';

    protected $guarded = ['id'];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
