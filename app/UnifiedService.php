<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedService extends Model
{
    protected $table = 'unified_services_job';

    public function jobs() {
        return $this->hasMany(UnifiedJob::class, 'service_id');
    }
}
