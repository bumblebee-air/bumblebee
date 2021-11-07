<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $table = 'general_setting';

    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone_number',
        'retailers_automatic_rating_sms',
    ];
}
