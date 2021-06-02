<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedJobType extends Model
{
    protected $table = 'unified_job_types';

    protected $fillable = ['name'];
}
