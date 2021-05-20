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

                    UnifiedCustomer::create([
                        "user_id" => $user->id,
                        "ac" => $collection[0],
                        "name" => $collection[1],
                        "street_1" => $collection[2],
                        "street_2" => $collection[3],
                        "town" => $collection[4],
                        "country" => $collection[5],
                        "post_code" => $collection[6],
                        "contact" => $collection[7],
                        "email" => $collection[8],
                        "phone" => $collection[9],
                        "mobile"  => $collection[10],
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
                    $checkIfExists->update([
                        "ac" => $collection[0],
                        "name" => $collection[1],
                        "street_1" => $collection[2],
                        "street_2" => $collection[3],
                        "town" => $collection[4],
                        "country" => $collection[5],
                        "post_code" => $collection[6],
                        "contact" => $collection[7],
                        "email" => $collection[8],
                        "phone" => $collection[9],
                        "mobile"  => $collection[10],
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
