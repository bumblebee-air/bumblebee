<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripePaymentLog extends Model
{
    protected $table = 'stripe_payment_logs';

    protected $fillable = [
        'model_id',
        'model_name',
        'description',
        'status',
        'operation_id',
        'operation_type',
        'fail_message'
    ];
}
