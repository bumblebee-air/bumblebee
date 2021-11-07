<?php

namespace  Modules\DoOrder\Driver\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\DoOrder\Driver\Entities\DriverProfile; 
use Illuminate\Support\Str;

/**
 * Class BuildingRepository
 * @package  Modules\Admin\Compound\Repositories
 *
 */
class DriverProfileRepository
{
    /**
     * @var array
     */

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DriverProfile::class;
    }


    function create($request)
    {
        DB::beginTransaction();
        
        $user = User::create([
            'name' => "$request->first_name $request->last_name",
            'email' => $request->email,
            'phone' => $request->phone_number,
            'password' => bcrypt(Str::random(6)),
            'user_role' => 'driver'
        ]);
        $client = \App\Client::where('name', 'DoOrder')->first();
        if ($client) {
            $user->clients()->attach($client->id);
        }
        $driver_data =  $request->only(['first_name', 'last_name','address' ,'address_coordinates','pps_number' , 'emergency_contact_name' ,'emergency_contact_number','max_package_size',  ]);
        $driver_data['user_id'] = $user->id;
        $driver_data['contact_channel'] = $request->contact_through;
        $driver_data['dob'] = $request->birthdate;
        $driver_data['transport'] = $request->transport_type;
        $driver_data['work_location'] = $request->work_location ? $request->work_location : '{"name":"N/A","coordinates":{"lat":"0","lng":"0"}}';
        $driver_data['legal_word_evidence'] = $request->proof_id ? $request->file('proof_id')->store('uploads/doorder_drivers_registration') : null;
        $driver_data['driver_license'] = $request->proof_driving_license ? $request->file('proof_driving_license')->store('uploads/doorder_drivers_registration') : null;
        $driver_data['driver_license_back'] = $request->proof_driving_license_back ? $request->file('proof_driving_license_back')->store('uploads/doorder_drivers_registration') : null;
        $driver_data['address_proof'] = $request->proof_address ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;
        $driver_data['insurance_proof'] = $request->proof_insurance ? $request->file('proof_address')->store('uploads/doorder_drivers_registration') : null;
        $profile = DriverProfile::create($driver_data);
        $stripe_manager = new StripeManager();
        $stripe_manager->createCustomAccount($user);
        CustomNotificationHelper::send('new_deliverer', $profile->id);
        DB::commit();
        return $building->id;
    }

    function update($request, $id)
    {
        

    }
}
