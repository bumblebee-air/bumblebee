<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedCustomer extends Model
{
    protected $table = 'unified_customers_list';

    protected $fillable = [
        "user_id",
        "ac",
        "name",
        "street_1",
        "street_2",
        "town",
        "country",
        "post_code",
        "contact",
        "email",
        "phone",
        "mobile",
        "hosted_pbx",
        "access_control",
        "cctv",
        "fire_alarm",
        "intruder_alarm",
        "wifi_data",
        "structured_cabling_system",
        "contract",
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
