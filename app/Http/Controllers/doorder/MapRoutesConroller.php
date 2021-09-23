<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\DriverProfile;
use App\Http\Controllers\Controller;

class MapRoutesConroller extends Controller
{
    public function index(){
        
        $accepted_deliverers = DriverProfile::where('is_confirmed','=',1)->get();
        
        return view('admin.doorder.map_routes',[ 'drivers'=>$accepted_deliverers]);
    }
    
    public function getRouteOfDriver(Request $request){
          //  dd($request);
        
        $route = array("deliverer_location"=> "53.31682848327396,-6.24794205957005",
            "17_pickup"=> "53.31966803641148,-6.2487762491371335",
            "921945_pickup"=> "53.321359944283834,-6.248003772940844",
            "921945_dropoff"=> "53.31807860730656,-6.247059635367602",
            "17_dropoff"=> "53.31741205490382,-6.247660450186938");
        
        return response()->json(array(
            "msg" => "test test",
            "driverId" => $request->driverId,
            "route"=>$route
        ));
    }
}