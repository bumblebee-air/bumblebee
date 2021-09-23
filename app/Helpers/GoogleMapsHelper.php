<?php

namespace App\Helpers;

class GoogleMapsHelper
{
    public static function getTheNearestLocation($locations, $destination) {
        $distances = [];
        $destination = ['lat' => 53.3242381, 'lon' => -6.1056228];
        foreach ($locations as $key => $location) {
            $location->coordinates = str_replace('lat', '"lat"', $location->coordinates);
            $location->coordinates = str_replace('lon', '"lon"', $location->coordinates);
            $location_coordinates_decoded = json_decode($location->coordinates, true);
            /*
             * Calculate distance between latitude and longitude
             * $location => from, $destination(customer location) => to
             */
            $theta    = $location_coordinates_decoded['lon'] - $destination['lon'];
            $dist    = sin(deg2rad($location_coordinates_decoded['lat'])) * sin(deg2rad($destination['lat'])) +  cos(deg2rad($location_coordinates_decoded['lat'])) * cos(deg2rad($destination['lat'])) * cos(deg2rad($theta));
            $dist    = acos($dist);
            $dist    = rad2deg($dist);
            $miles    = $dist * 60 * 1.1515;
            $km    = round($miles * 1.609344, 2);

            // Convert unit and return distance
            $distances[] = $km;

        }
        return $locations[array_key_first(array_keys($distances, min($distances)))];
    }
}
