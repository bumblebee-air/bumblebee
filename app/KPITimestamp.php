<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KPITimestamp extends Model
{
    protected $table = 'kpi_timestamps';

    protected $fillable = [
        'assigned'
    ];
}
