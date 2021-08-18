<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedEngineerJob extends Model
{
    protected $table = 'unified_engineers_jobs';

    public function job() {
        return $this->belongsTo(UnifiedCustomer::class, 'job_id');
    }

    public function engineer() {
        return $this->belongsTo(UnifiedEngineer::class, 'engineer_id');
    }
}
