<?php
namespace App\Http\Controllers\garden_help;

use App\GardenServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceTypesController extends Controller
{

    public function getServiceTypesTable()
    {
        /*
         * $service_types = collect([
         * [
         * 'id' => 1,
         * 'service_type' => 'Garden maintenance',
         * 'min_hours' => 4,
         * 'rate_per_hour' => '€15/€30',
         * 'max_property_size' => '1-299/300-500'
         * ],
         * [
         * 'id' => 2,
         * 'service_type' => 'Grass cutting',
         * 'min_hours' => 2.5,
         * 'rate_per_hour' => '€15',
         * 'max_property_size' => '1-3999'
         * ]
         * ]);
         */
        $service_types = GardenServiceType::paginate(20);
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
        $this->validate($request, [
            'service_type' => 'required',
            'min_hours' => 'required|integer',
            'rate_per_hour0' => 'required|integer',
            'max_property_size0' => 'required'
        ]);
        GardenServiceType::create([
            'name' => $request->service_type,
            'min_hours' => $request->min_hours,
            'rate_per_hour' => $request->rate_per_hour0,
            'max_property_size' => $request->max_property_size0
        ]);
        alert()->success('Service type has been saved successfully');

        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }

    public function getSingleServiceType($client, $id)
    {
        $service_type = GardenServiceType::find($id);
        if (! $service_type) {
            abort(404);
        }
        $ratePropertySizes = collect([
            [
                'rate_per_hour' => $service_type->rate_per_hour,
                'max_property_size' => $service_type->max_property_size
            ]
        ]);
        return view('admin.garden_help.service_types.single_service_type', [
            'service_type' => $service_type,
            'readOnly' => 1,
            'ratePropertySizes' => $ratePropertySizes
        ]);
    }

    public function getSingleServiceTypeEdit($client, $id)
    {
        $service_type = GardenServiceType::find($id);
        if (! $service_type) {
            abort(404);
        }
        
        $ratePropertySizes = collect([
            [
                'rate_per_hour' => $service_type->rate_per_hour,
                'max_property_size' => $service_type->max_property_size
            ]
        ]);
        return view('admin.garden_help.service_types.single_service_type', [
            'service_type' => $service_type,
            'readOnly' => 0,
             'ratePropertySizes' => $ratePropertySizes
        ]);
    }

    public function postEditServiceType(Request $request,$client,$id)
    {
        $service_type = GardenServiceType::find($id);
        if (!$service_type) {
            abort(404);
        }
        $this->validate($request, [
            'service_type' => 'required',
            'min_hours' => 'required|integer',
            'rate_per_hour0' => 'required|integer',
            'max_property_size0' => 'required',
        ]);
        $service_type->update([
            'name' => $request->service_type,
            'min_hours' => $request->min_hours,
            'rate_per_hour' => $request->rate_per_hour0,
            'max_property_size' => $request->max_property_size0,
        ]);
        alert()->success('Service type has been updated successfully');

        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }
}
