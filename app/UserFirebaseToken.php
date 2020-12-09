<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFirebaseToken extends Model
{
    protected $table = 'users_firebase_tokens';

    protected $fillable = [
        'user_id',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
