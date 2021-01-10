<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model
{
    protected $table = "users_clients";

    protected $fillable = ['user_id', 'client_id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
