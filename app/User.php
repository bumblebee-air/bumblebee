<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_profile_completed'
    ];

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function client(){
        return $this->hasOne(UserClient::class, 'user_id', 'id');
    }

    public function firebase_tokens() {
        return $this->hasMany(UserFirebaseToken::class, 'user_id');
    }

    public function driver_profile(){
        return $this->hasOne(DriverProfile::class, 'user_id', 'id');
    }
}
