<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens; /*SoftDeletes*/

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_profile_completed', 'user_role', 'phone'
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

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function client()
    {
        return $this->hasOne(UserClient::class, 'user_id', 'id');
    }

    public function firebase_tokens()
    {
        return $this->hasMany(UserFirebaseToken::class, 'user_id');
    }

    public function driver_profile()
    {
        return $this->hasOne(DriverProfile::class, 'user_id', 'id');
    }

    public function retailer_profile()
    {
        return $this->hasOne(Retailer::class, 'user_id');
    }

    public function contractor_profile()
    {
        return $this->hasOne(Contractor::class, 'user_id');
    }

    public function stripe_account()
    {
        return $this->hasOne(StripeAccount::class, 'user_id');
    }

    public function engineer_profile()
    {
        return $this->hasOne(UnifiedEngineer::class, 'user_id');
    }

    public function contractor_jobs()
    {
        return $this->hasMany(Customer::class, 'contractor_id');
    }

    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'driver', 'id');
    }
    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function retailerorders()
    {
        return $this->hasMany(Order::class, 'retailer_id', 'id');
    }

    public function properties()
    {
        return $this->hasMany(CustomerProperty::class, 'user_id');
    }
}
