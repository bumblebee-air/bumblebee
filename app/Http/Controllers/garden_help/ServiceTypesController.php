<?php
namespace App\Http\Controllers\garden_help;

use App\GardenServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceTypesController extends Controller
{

    public function getServiceTypesTable()
    {
        $service_types = GardenServiceType::paginate(20);

        foreach ($service_types as $service_type) {
            $rate_hours = '';
            $property_sizes = '';
            $rate_property_sizes_json = json_decode($service_type->rate_property_sizes, true);
            foreach ($rate_property_sizes_json as $key => $item) {
                $rate_hours .= '€' . $item['rate_per_hour'] . ($key == count($rate_property_sizes_json) - 1 ? '' : "-");
                $property_sizes .= $item['max_property_size_from'] . '-' . $item['max_property_size_to'] . ($key == count($rate_property_sizes_json) - 1 ? '' : "/");
            }
            $service_type->rate_hours = $rate_hours;
            $service_type->property_sizes = $property_sizes;
        }
        return view('admin.garden_help.service_types.index', [
            'service_types' => $service_types
        ]);
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
            'rate_property_sizes' => 'required',
            'is_service_recurring' => 'required',
        ]);
        GardenServiceType::create([
            'name' => $request->service_type,
            'min_hours' => $request->min_hours,
            'rate_property_sizes' => $request->rate_property_sizes,
            'is_service_recurring' => $request->is_service_recurring,
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
        return view('admin.garden_help.service_types.single_service_type', [
            'service_type' => $service_type,
            'readOnly' => 1
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
                'max_property_size_from' => $service_type->max_property_size
            ]
        ]);
        $service_type->is_service_recurring =0;
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
            'min_hours' => 'required|regex:/^\d*(\.\d{2})?$/',
            'rate_property_sizes' => 'required',
            'is_service_recurring' => 'required',
        ]);
        $service_type->update([
            'name' => $request->service_type,
            'min_hours' => $request->min_hours,
            'rate_property_sizes' => $request->rate_property_sizes,
            'is_service_recurring' => $request->is_service_recurring,
        ]);
        alert()->success('Service type has been updated successfully');

        return redirect()->route('garden_help_getServiceTypes', 'garden_help');
    }

    public function postDeleteServiceType(Request $request)
    {
        $service_type = GardenServiceType::find($request->typeId);
        if (! $service_type) {
            abort(404);
        }
        $service_type->delete();
        alert()->success('Service type deleted successfully');
        return redirect()->back();
    }
}
