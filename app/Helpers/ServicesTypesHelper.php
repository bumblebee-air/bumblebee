<?php


namespace App\Helpers;

use App\Customer;

class ServicesTypesHelper {


    public static function getJobServicesTypesAmount(Customer $customer, $isActual = false): float
    {
        $amount = 0.0;

        //Calc Amount
        if ($isActual) {
            $job_services = $customer->job_services_types_json;
        } else {
            $job_services = json_decode($customer->services_types_json, true);
        }
        foreach ($job_services as $job_service) {
            $property_size = str_replace(' Square Meters', '', $customer->property_size);
            $rate_property_sizes = json_decode($job_service['rate_property_sizes'], true);
            foreach ($rate_property_sizes as $rate_property_size) {
                $size_from = $rate_property_size['max_property_size_from'];
                $size_to = $rate_property_size['max_property_size_to'];
                $rate_property_size = $rate_property_size['rate_per_hour'];
                if (floatval($property_size) >= floatval($size_from) && floatval($property_size) <= floatval($size_to)) {
                    $service_price = floatval($rate_property_size) * floatval($job_service['min_hours']);
                    $amount += $service_price;
                }
            }
        }
        return $amount;
    }

    public static function getVat($percentage, $amount) {
        return ($percentage/100)*$amount;
    }
}
