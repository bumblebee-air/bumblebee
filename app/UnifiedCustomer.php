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
        "contacts",
        "address",
        "contract_start_date",
        "contract_end_date",
        "address_coordinates"
    ];

    protected $casts = [
        "address_coordinates" => "array"
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function services() {
        return $this->hasMany(UnifiedCustomerService::class, 'customer_id');
    }
}
