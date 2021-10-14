<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedService extends Model
{
    protected $table = 'unified_services_job';

    public function jobs() {
        return $this->hasMany(UnifiedJob::class, 'service_id');
    }

    public function customers() {
        return $this->hasMany(UnifiedCustomerService::class, 'service_id');
    }

    public function customers_selected_values() {
        return $this->hasMany(UnifiedCustomerProductSelectedValues::class, 'service_id');
    }
}
