<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobComment extends Model
{
    protected $table = 'job_comments';

    protected $fillable = [
        'job_id',
        'job_model',
        'comment',
        'user_id'
    ];

    public function job() {
        return $this->morphTo('job');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
