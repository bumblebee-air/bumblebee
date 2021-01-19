<?php

namespace App\Http\Controllers\doorder;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        $user_role = auth()->user()->user_role;
        if($user_role == 'retailer'){

        } else {
            $admin_data = $this->adminDashboardData();
            $drivers_arr = $admin_data['drivers_arr'];
            return view('admin.doorder.dashboard',compact('drivers_arr'));
        }
    }

    public function getAdminMap(){
        $drivers = User::with('driver_profile')->where('user_role','=','driver')->get();
        $drivers_arr = [];
        foreach($drivers as $driver){
            if($driver->driver_profile!=null && $driver->driver_profile->latest_coordinates!=null){
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver'=>[
                        'name'=>$driver->name
                    ],
                    'lat'=>$lat,
                    'lon'=>$lon,
                    'timestamp'=>$coords_timestamp->toTimeString()
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return view('admin.doorder.drivers_map',compact('drivers_arr'));
    }

    private function retailerDashboardData(){

    }

    private function adminDashboardData(){
        $drivers = User::with('driver_profile')->where('user_role','=','driver')->get();
        $drivers_arr = [];
        foreach($drivers as $driver){
            if($driver->driver_profile!=null && $driver->driver_profile->latest_coordinates!=null){
                $coords = json_decode($driver->driver_profile->latest_coordinates);
                $lat = $coords->lat;
                $lon = $coords->lng;
                $coords_timestamp = new Carbon($driver->driver_profile->coordinates_updated_at);
                $drivers_arr[] = [
                    'driver'=>[
                        'name'=>$driver->name,
                        'id'=>$driver->id
                    ],
                    'lat'=>$lat,
                    'lon'=>$lon,
                    'timestamp'=>$coords_timestamp->format('H:i')
                ];
            }
        }
        $drivers_arr = json_encode($drivers_arr);
        return ['drivers_arr'=>$drivers_arr];
    }
}
