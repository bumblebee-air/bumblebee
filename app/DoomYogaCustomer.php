<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoomYogaCustomer extends Model
{
    protected $table = 'doomyoga_customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'level',
        'email',
        'user_id',
        'phone',
        'contact_through',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
