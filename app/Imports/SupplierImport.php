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