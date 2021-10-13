<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedCustomerProductSelectedValues extends Model
{
    protected $table = 'unified_customer_products_selected_values';

    protected $fillable = [
        'customer_id',
        'service_id',
        'selected_values',
    ];

    protected $casts = [
        'selected_values' => 'array'
    ];

    public function customer() {
        return $this->belongsTo(UnifiedCustomer::class, 'customer_id');
    }

    public function service() {
        return $this->belongsTo(UnifiedService::class, 'service_id');
    }
}
