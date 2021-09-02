<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedEngineerJobExpenses extends Model
{
    protected $table = 'unified_engineers_jobs_expenses';

    protected $fillable = [
        'name',
        'cost',
        'comment',
        'file',
        'engineer_job_id',
    ];

    public function engineer_job() {
        return $this->belongsTo(UnifiedEngineerJob::class, 'engineer_job_id');
    }
}
