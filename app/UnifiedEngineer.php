<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedEngineer extends Model
{
    protected $table = 'unified_engineers';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'address_coordinates',
        'job_type',
    ];
}
