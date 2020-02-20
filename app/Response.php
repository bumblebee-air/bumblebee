<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['keywords', 'audio'];

    /**
     * Get the response's keyword
     *
     * @param  string  $value
     * @return string
     */
    public function getKeywordsAttribute($value)
    {
        return json_decode($value);
    }
}
