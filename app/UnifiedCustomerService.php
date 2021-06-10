<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedCustomerService extends Model
{
    protected $table = 'unified_customer_service';

    protected $fillable = [
        'service_id', 'customer_id'
    ];

    public function customer() {
        return $this->belongsTo(UnifiedCustomer::class, 'customer_id');
    }

    public function service() {
        return $this->belongsTo(UnifiedService::class, 'service_id');
    }
}
