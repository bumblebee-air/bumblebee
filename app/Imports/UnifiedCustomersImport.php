<?php

namespace App\Imports;

use App\UnifiedCustomer;
use App\UnifiedCustomerService;
use App\UnifiedService;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnifiedCustomersImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collections)
    {
        $existedUsers = [];
        $importingServices = [
            [
                'index' => 11,
                'name' => 'hosted_pbx'
            ],
            [
                'index' => 12,
                'name' => 'access_control'
            ],
            [
                'index' => 13,
                'name' => 'cctv'
            ],
            [
                'index' => 14,
                'name' => 'fire_alarm'
            ],
            [
                'index' => 15,
                'name' => 'intruder_alarm'
            ],
            [
                'index' => 16,
                'name' => 'wifi_data'
            ],
            [
                'index' => 17,
                'name' => 'structured_cabling_system'
            ],
        ];
        foreach ($collections as $key => $collection) {
            if ($key != 0) {
                $checkIfExists = User::where('email', $collection['8'])->first();
                if (!$checkIfExists) {
                    $user = new User();
                    $user->name = $collection[1];
                    $user->email = $collection[8];
                    $user->phone = $collection[10];
                    $user->user_role = 'unified_customer';
                    $user->password = bcrypt(Str::random(8));
                    $user->save();

                    $contacts_array = [
                        [
                            'contactName' => $collection[7],
                            'position' => '',
                            'contactNumber' => $collection[10],
                            'contactEmail' => $collection[8],
                        ]
                    ];
                    $customer = UnifiedCustomer::create([
                        "user_id" => $user->id,
                        "ac" => $collection[0],
                        "name" => $collection[1],
                        "address" => "$collection[2], $collection[3], $collection[4], $collection[5]",
                        "post_code" => $collection[6],
                        "contacts" => json_encode($contacts_array),
                        "contract" => $collection[18] == 'YES ' ? true : false,
                        "phone" => $collection[9],
                    ]);
                    foreach ($importingServices as $importingService) {
                        if ($collection[$importingService['index']] == 'YES ') {
                            $service = UnifiedService::where('service_code', $importingService['name'])->first();
                            if ($service) {
                                UnifiedCustomerService::create([
                                    'service_id' => $service->id,
                                    'customer_id' => $customer->id
                                ]);
                            }
                        }
                    }
                } else {
                    $contacts_array = [
                        [
                            'contactName' => $collection[9],
                            'position' => '',
                            'contactNumber' => $collection[10],
                            'contactEmail' => $collection[8],
                        ]
                    ];
                    $customer = UnifiedCustomer::where('user_id', $checkIfExists->id)->first();
                    if ($customer) {
                        $customer->update([
                            "user_id" => $checkIfExists->id,
                            "ac" => $collection[0],
                            "name" => $collection[1],
                            "address" => "$collection[2], $collection[3], $collection[4], $collection[5]",
                            "post_code" => $collection[6],
                            "contacts" => json_encode($contacts_array),
                            "phone" => $collection[9],
                        ]);
                        UnifiedCustomerService::where('customer_id', $checkIfExists->id)->delete();
                        foreach ($importingServices as $importingService) {
                            if ($collection[$importingService['index']] == 'YES') {
                                $service = UnifiedService::where('service_code', $importingService['name'])->first();
                                if ($service) {
                                    UnifiedCustomerService::create([
                                        'service_id' => $service->id,
                                        'customer_id' => $customer->id
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (count($existedUsers) > 0) {
            $text = '';
            foreach ($existedUsers as $existedUser) {
                $text .= " $existedUser[0] / $collection[10],";
            }
            alert()->success('File has been imported successfully, Duplicate entries were found for the following customers: ');
        } else {
            alert()->success('File has been imported successfully.');
        }
    }
}
