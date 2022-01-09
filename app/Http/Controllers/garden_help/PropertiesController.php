<?php
namespace App\Http\Controllers\garden_help;

use App\CustomerProperty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{

    public function index()
    {
        $properties = CustomerProperty::where('user_id', auth()->user()->id)->get();
        return view('admin.garden_help.properties.list', [
            'properties' => $properties
        ]);
    }

    public function add()
    {
        $current_user = auth()->user();

        return view('admin.garden_help.properties.add_property', [
            'current_user' => $current_user
        ]);
    }

    public function save(Request $request)
    {
        dd($request);
        $this->validate($request, [
            'type_of_work' => 'required',
            'work_location' => 'required',
            'location' => 'required',
            'location_coordinates' => 'required',
            'property_size' => 'required',
            'site_details' => 'required',
            'is_parking_access' => 'required',
            'area_coordinates' => 'required'
            // 'services_types_json' => 'required',
        ]);
        CustomerProperty::create([
            'type_of_work' => $request->type_of_work,
            'work_location' => $request->work_location,
            'location' => $request->location,
            'location_coordinates' => $request->location_coordinates,
            'property_size' => $request->property_size,
            'site_detail' => $request->site_details,
            'is_parking_access' => $request->is_parking_access,
            'area_coordinates' => $request->area_coordinates,
            'services_types_json' => '', // $request->services_types_json,
            'user_id' => $request->customer_id
        ]);

        alert()->success('Property has saved successfully');
        return redirect()->to('garden-help/properties');
    }

    public function edit($client_name, $id)
    {
        // dd($client_name,$id);
        $current_user = auth()->user();
        
        $property = CustomerProperty::find($id);
        if (! $property) {
            alert()->error('The property ID is invalid.');
            return redirect()->back();
        }
        
        $property->images = array($property->property_photo,$property->property_photo,$property->property_photo,$property->property_photo);
        
        return view('admin.garden_help.properties.edit_property', [
            'current_user' => $current_user,
            'property' => $property
        ]);
    }

    public function update(Request $request, $id)
    {
        dd($request);
        $property = CustomerProperty::find($id);
        if (! $property) {
            alert()->error('The Job ID is invalid.');
            return redirect()->back();
        }
        $this->validate($request, [
            'type_of_work' => 'required',
            'work_location' => 'required',
            'location' => 'required',
            'location_coordinates' => 'required',
            'property_size' => 'required',
            'site_detail' => 'required',
            'is_parking_access' => 'required',
            'area_coordinates' => 'required',
            'services_types_json' => 'required'
        ]);
        $property->update([
            'type_of_work' => $request->type_of_work,
            'work_location' => $request->work_location,
            'location' => $request->location,
            'location_coordinates' => $request->location_coordinates,
            'property_size' => $request->property_size,
            'site_detail' => $request->site_detail,
            'is_parking_access' => $request->is_parking_access,
            'area_coordinates' => $request->area_coordinates,
            'services_types_json' => $request->services_types_json
        ]);
        alert('Property has updated successfully');
        return redirect()->route('garden_help_getProperties');
    }

    public function delete(Request $request)
    {
        $id = $request->property_id;
        $property = CustomerProperty::find($id);
        if (! $property) {
            alert()->error('The Job ID was invalid.');
            return redirect()->back();
        }
        $property->delete();
        alert()->success('Property has deleted successfully');
        return redirect()->to('garden-help/properties');
    }
}
