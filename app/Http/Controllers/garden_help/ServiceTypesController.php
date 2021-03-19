<?php
namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceTypesController extends Controller
{
    public function getServiceTypesTable()
    {
        $service_types = collect([
            [
                'id' => 1,
                'service_type' => 'Garden maintenance',
                'min_hours' => 4,
                'rate_per_hour' => '€15/€30',
                'max_property_size' => '1-299/300-500'
            ],
            [
                'id' => 2,
                'service_type' => 'Grass cutting',
                'min_hours' => 2.5,
                'rate_per_hour' => '€15',
                'max_property_size' => '1-3999'
            ]
        ]);

        return view('admin.garden_help.service_types.index', [
            'service_types' => $service_types
        ]);
    }

    public function postDeleteServiceType(Request $request)
    {
        // dd($request->typeId);
        alert()->success('Service type deleted successfully');

        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }

    public function addServiceType()
    {
        return view('admin.garden_help.service_types.add_service_type');
    }

    public function postAddServiceType(Request $request)
    {
        // dd($request);
        alert()->success('Service type added successfully');

        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }

    public function getSingleServiceType($client, $id){
        $ratePropertySizes = collect([
            [
                'rate_per_hour' => 10,
                'max_property_size' => 30
            ],
            [
                'rate_per_hour' => 100,
                'max_property_size' => 50
            ],
        ]);
        
        return view('admin.garden_help.service_types.single_service_type', [
            'service_type_id'=>$id,
            'service_type' => 'grass cutting',
            'min_hours' => 5,
            'readOnly' => 1,'ratePropertySizes'=>$ratePropertySizes
        ]);
    }
    public function getSingleServiceTypeEdit($client,$id)
    {
        
        $ratePropertySizes = collect([
            [
                'rate_per_hour' => 10,
                'max_property_size' => 30
            ],
            [
                'rate_per_hour' => 100,
                'max_property_size' => 50
            ],
        ]);
        
        return view('admin.garden_help.service_types.single_service_type', [
            'service_type_id'=>$id,
            'service_type' => 'grass cutting',
            'min_hours' => 5,
            'readOnly' => 0,'ratePropertySizes'=>$ratePropertySizes
        ]);
    }
    
    public function postEditServiceType(Request $request){
        //dd($request);
        
        alert()->success('Service type updated successfully');
        
        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }

    
}
