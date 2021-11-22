<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\DriverProfile;
use App\Http\Controllers\Controller;

class MapRoutesConroller extends Controller
{

    public function index()
    {
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();
        
        $route1 = array(
            array(
                "deliverer_location" => "53.40264481,-6.4309825"
            ),
            array(
                "coordinates" =>"53.4264481,-6.243099098",
                "order_id" => "14",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.42604481,-6.12499098",
                "order_id" => "13",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.29034,-6.17659",
                "order_id" => "15",
                "type" => "pickup"
            ),
            
            array(
                "coordinates" => "53.289851,-6.24756",
                "order_id" => "14",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.304581,-6.205543",
                "order_id" => "13",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.34581, -6.25543",
                "order_id" => "15",
                "type" => "dropoff"
            )
        );
        $route2 = array(
            array(
                "deliverer_location" => "53.34581,-6.5285543"
            ),
            array(
                "coordinates" =>"53.334981, -6.526025",
                "order_id" => "24",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.32604,-6.531861",
                "order_id" => "23",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.234868,-6.539165",
                "order_id" => "24",
                "type" => "dropoff"
            ),
            array(
                "coordinates" =>"53.2034868,-6.5020463",
                "order_id" => "23",
                "type" => "dropoff"
            )
        );
        $routes = array($route1, $route2);
        

        return view('admin.doorder.map_routes', [
            'drivers' => $accepted_deliverers,

            'map_routes' =>json_encode($routes)
        ]);
    }

    public function getRouteOfDriver(Request $request)
    {
        // dd($request);
        $route = array(
            array(
                "deliverer_location" => "53.31682848327396,-6.24794205957005"
            ),
            array(
                "coordinates" => "53.31966803641148,-6.2487762491371335",
                "order_id" => "24",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.321359944283834,-6.248003772940844",
                "order_id" => "25",
                "type" => "pickup"
            ),

            array(
                "coordinates" => "53.31807860730656,-6.247059635367602",
                "order_id" => "24",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.31741205490382,-6.247660450186938",
                "order_id" => "25",
                "type" => "dropoff"
            )
        );

        return response()->json(array(
            "msg" => "test test",
            "driverId" => $request->driverId,
            "route" => $route
        ));
    }

    public function assignDriver_enableRouteOptimization(Request $request)
    {
        // dd($request);
        
        $route1 = array(
            array(
                "deliverer_location" => "53.40264481,-6.4309825"
            ),
            array(
                "coordinates" =>"53.4264481,-6.243099098",
                "order_id" => "14",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.42604481,-6.12499098",
                "order_id" => "13",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.29034,-6.17659",
                "order_id" => "15",
                "type" => "pickup"
            ),
            
            array(
                "coordinates" => "53.289851,-6.24756",
                "order_id" => "14",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.304581,-6.205543",
                "order_id" => "13",
                "type" => "dropoff"
            ),
            array(
                "coordinates" => "53.34581, -6.25543",
                "order_id" => "15",
                "type" => "dropoff"
            )
        );
        $route2 = array(
            array(
                "deliverer_location" => "53.34581,-6.5285543"
            ),
            array(
                "coordinates" =>"53.334981, -6.526025",
                "order_id" => "24",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.32604,-6.531861",
                "order_id" => "23",
                "type" => "pickup"
            ),
            array(
                "coordinates" => "53.234868,-6.539165",
                "order_id" => "24",
                "type" => "dropoff"
            ),
            array(
                "coordinates" =>"53.2034868,-6.5020463",
                "order_id" => "23",
                "type" => "dropoff"
            )
        );
       $routes = array($route1, $route2);
        
      
        return response()->json(array(
            "msg" => "test test",
            "selectedOrders" => $request->selectedOrders,
            "selectesDrivers" => $request->selectesDrivers,
            "mapRoutes"=> json_encode($routes)
        ));
    }
    
    public function getMapRoutes(Request $request) {
        //dd($request->map_routes);
        
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();
        
        return view('admin.doorder.map_routes', [
            'drivers' => $accepted_deliverers,
            'map_routes' => $request->map_routes
        ]);
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