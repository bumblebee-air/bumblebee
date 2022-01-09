<?php

use Illuminate\Database\Seeder;

class changeProperyPhotoToArray extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $properties = \App\CustomerProperty::all();
        foreach ($properties as $property) {
            if (!is_array($property->property_photo) && $property->property_photo != null) {
                $property->update([
                    'property_photo' => json_encode([$property->property_photo])
                ]);
            }
        }

        $customers_registration = \App\Customer::all();
        foreach ($customers_registration as $customer) {
            if (!is_array($customer->property_photo) && $customer->property_photo != null) {
                $customer->update([
                    'property_photo' => json_encode([$customer->property_photo])
                ]);
            }
        }
    }
}
