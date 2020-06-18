<?php

namespace App\Imports;

use App\Enums\AccountTypes;
use App\Managers\RegistrationManager;
use App\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;
//use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\User;
use App\Models\UserProfile;

class SupplierImport implements ToCollection,WithChunkReading,WithCustomChunkSize,WithHeadingRow{

    /*public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }*/

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            //dd($row);
            $name = $row['name'];
            $phone_number = (string)$row['phone'];
            $email = $row['email'];
            $county = $row['county'];
            $latitude = (string)$row['latitude'];
            $longitude = (string)$row['longitude'];
            //create new supplier entry
            $supplier = new Supplier();
            $supplier->name = $name;
            if(substr($phone_number,0,2)==='08' || substr($phone_number,0,1)==='8'){
                if(substr($phone_number,0,1)==='0'){
                    $phone_number = substr($phone_number,1);
                }
                $phone_number = '+353'.$phone_number;
            }elseif(substr($phone_number,0,3)==='010' || substr($phone_number,0,3)==='011' ||
                substr($phone_number,0,3)==='012'|| substr($phone_number,0,2)==='10' ||
                substr($phone_number,0,2)==='11' || substr($phone_number,0,2)==='12'){
                if(substr($phone_number,0,1)==='0'){
                    $phone_number = substr($phone_number,1);
                }
                $phone_number = '+20'.$phone_number;
            }
            $supplier->phone = $phone_number;
            $supplier->email = $email;
            $supplier->county = $county;
            $supplier->latitude = explode(',',$latitude)[0];
            $supplier->longitude = explode(',',$longitude)[0];
            $supplier->save();
        }
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 50;
    }

    /*public function startRow(): int
    {
        return 3;
    }*/
}