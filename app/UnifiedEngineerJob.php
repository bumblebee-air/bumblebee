<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedEngineerJob extends Model
{
    protected $table = 'unified_engineers_jobs';

    protected $fillable = [
        'status',
        'rejection_reason',
        'skip_reason',
        'additional_service_id',
        'number_of_hours',
        'job_images',
        'engineer_id',
        'job_id',
        'expenses_receipt'
    ];

    public $casts = [
        'job_images' => 'array'
    ];

    public function job() {
        return $this->belongsTo(UnifiedCustomer::class, 'job_id');
    }

    public function engineer() {
        return $this->belongsTo(UnifiedEngineer::class, 'engineer_id');
    }

    public function expenses() {
        return $this->hasMany(UnifiedEngineerJobExpenses::class, 'engineer_job_id');
    }
}
