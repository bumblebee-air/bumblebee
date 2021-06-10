<?php

namespace App\Imports;

use App\UnifiedCustomer;
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
                            'contactName' => $collection[9],
                            'position' => '',
                            'contactNumber' => $collection[10],
                            'contactEmail' => $collection[8],
                        ]
                    ];
                    UnifiedCustomer::create([
                        "user_id" => $user->id,
                        "ac" => $collection[0],
                        "name" => $collection[1],
                        "address" => "$collection[2], $collection[3], $collection[4], $collection[5]",
                        "post_code" => $collection[6],
                        "contacts" => json_encode($contacts_array),
                        "phone" => $collection[9],
                        "hosted_pbx"  => $collection[11] == 'YES ' ? true : false,
                        "access_control" => $collection[12] == 'YES ' ? true : false,
                        "cctv" => $collection[13] == 'YES ' ? true : false,
                        "fire_alarm" => $collection[14] == 'YES ' ? true : false,
                        "intruder_alarm" => $collection[15] == 'YES ' ? true : false,
                        "wifi_data" => $collection[16] == 'YES ' ? true : false,
                        "structured_cabling_system" => $collection[17] == 'YES ' ? true : false,
                        "contract" => $collection[18] == 'YES ' ? true : false,
                    ]);
                } else {
                    $contacts_array = [
                        [
                            'contactName' => $collection[9],
                            'position' => '',
                            'contactNumber' => $collection[10],
                            'contactEmail' => $collection[8],
                        ]
                    ];
                    $checkIfExists->update([
                        "ac" => $collection[0],
                        "name" => $collection[1],
                        "address" => "$collection[2], $collection[3], $collection[4], $collection[5]",
                        "post_code" => $collection[6],
                        "contacts" => json_encode($contacts_array),
                        "phone" => $collection[9],
                        "hosted_pbx"  => $collection[11] == 'YES ' ? true : false,
                        "access_control" => $collection[12] == 'YES ' ? true : false,
                        "cctv" => $collection[13] == 'YES ' ? true : false,
                        "fire_alarm" => $collection[14] == 'YES ' ? true : false,
                        "intruder_alarm" => $collection[15] == 'YES ' ? true : false,
                        "wifi_data" => $collection[16] == 'YES ' ? true : false,
                        "structured_cabling_system" => $collection[17] == 'YES ' ? true : false,
                        "contract" => $collection[18] == 'YES ' ? true : false,
                    ]);
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
