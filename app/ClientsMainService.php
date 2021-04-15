<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientsMainService extends Model
{
    protected $table = 'main_service';

    public function service() {
        return $this->morphTo();
    }
}
