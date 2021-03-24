<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    protected $table = 'stripe_accounts';

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
