<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedJob extends Model
{
    protected $table = 'unified_jobs';

    public function service() {
        return $this->belongsTo(UnifiedService::class, 'service_id');
    }

    public function customer() {
        return $this->belongsTo(UnifiedCustomer::class, 'company_id');
    }

    public function engineers() {
        return $this->hasMany(UnifiedEngineerJob::class, 'job_id');
    }
}
