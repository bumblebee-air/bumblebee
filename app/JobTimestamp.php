<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobTimestamp extends Model
{
    public $table = 'jobs_timestamps';

    protected $fillable = [
        'model_type',
        'model_id',
        'started_at',
        'stopped_at',
    ];
}
