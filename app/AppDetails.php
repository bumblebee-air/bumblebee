<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppDetails extends Model
{
    protected $table = 'app_details';

    protected $fillable = [
        'client_id',
        'version',
        'os',
    ];

    public function client() {
        $this->belongsTo(Client::class, 'client_id');
    }
}
