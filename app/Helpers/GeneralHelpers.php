<?php

namespace App\Helpers;

use App\Client;

class GeneralHelpers
{
    public static function getUserClientViaRole($role) {
        $client_name = collect([]);
        switch ($role) {
            case "driver":
                $client_name = 'DoOrder';
                break;
            case "unified_engineer":
                $client_name = "Unified";
                break;
            default:
                $client_name = null;
        }
        return Client::where('name', $client_name)->first();
    }
}
