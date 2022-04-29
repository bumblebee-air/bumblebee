<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTwoFactor extends Model
{
    protected $table = 'users_two_factor';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
