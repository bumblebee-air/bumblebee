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
        
        $route = array(
            array("deliverer_location"=> "53.31682848327396,-6.24794205957005"),
            array("coordinates"=>"53.31966803641148,-6.2487762491371335","order_id"=>"24","type"=>"pickup"),
            array("coordinates"=>"53.321359944283834,-6.248003772940844","order_id"=>"25","type"=>"pickup"),
            
            
            array("coordinates"=>"53.31807860730656,-6.247059635367602","order_id"=>"24","type"=>"dropoff"),
            array("coordinates"=>"53.31741205490382,-6.247660450186938","order_id"=>"25","type"=>"dropoff"),
            
        );
             
        return response()->json(array(
            "msg" => "test test",
            "driverId" => $request->driverId,
            "route"=>$route,
           
        ));
    }
}

/**** [   {"deliverer_location": "53.425334,-6.231581"},
    {"coordinates": "53.34581,-6.25543",
        "order_id": "14",
        "type": "pickup"},
    {"coordinates": "51.89851,-8.4756",
        "order_id": "13",
        "type": "pickup"},
    {"coordinates": "51.89851,-8.4756",
        "order_id": "15",
        "type": "pickup"},
    {"coordinates": "53.18262,-6.80733",
        "order_id": "14",
        "type": "dropoff"},
    {"coordinates": "53.2744695,-6.1297354",
        "order_id": "13",
        "type": "dropoff"},
    {"coordinates": "53.35958,-6.24831",
        "order_id": "15",
        "type": "dropoff"}
]   
****/