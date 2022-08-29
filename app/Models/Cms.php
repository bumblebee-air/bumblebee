<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    protected $guarded = ['id'];
    protected $table = 'cms_pages';

    protected $fillable = [
        'text',
        'slug',
        'name'
    ];
}
