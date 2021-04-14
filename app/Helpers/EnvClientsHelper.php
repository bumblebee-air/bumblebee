<?php

namespace App\Helpers;

use App\EnvData;

class EnvClientsHelper
{
    public static function getEnvDataFunction($client_id, $key):string {
        $env_data = EnvData::where('key', $key)
            ->where('client_id', $client_id)->first();
        $returned_data = '';
        if($env_data) {
            $returned_data=$env_data->value;
        }
        return $returned_data;
    }
}
