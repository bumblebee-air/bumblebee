<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnifiedCompany extends Model
{
    protected $table = 'unified_companies';

    protected $fillable = ['name'];
}
