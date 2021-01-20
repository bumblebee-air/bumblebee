<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $table = 'retailers';

    public function orders() {
        return $this->hasMany(Order::class, 'retailer_id');
    }
}
