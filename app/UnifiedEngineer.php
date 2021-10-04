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
        'user_id'
    ];

    protected $casts = [
        'address_coordinates' => 'array'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
