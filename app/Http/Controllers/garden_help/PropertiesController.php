<?php

namespace App\Http\Controllers\garden_help;

use App\CustomerProperty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index() {
        $properties = CustomerProperty::where('user_id', auth()->user()->id)->paginate(50);
        return view('', ['properties' => $properties]);
    }

    public function edit($id) {
        $property = CustomerProperty::find($id);
        if (!$property) {
            alert()->error('The Job ID is invalid.');
            return redirect()->back();
        }
        return view('', ['property' => $property]);
    }

    public function save(Request $request) {
        $this->validate($request, [
            'type_of_work' => 'required',
            'work_location' => 'required',
            'location' => 'required',
            'location_coordinates' => 'required',
            'property_size' => 'required',
            'site_detail' => 'required',
            'is_parking_access' => 'required',
            'area_coordinates' => 'required',
            'services_types_json' => 'required',
        ]);
        CustomerProperty::create([
            'type_of_work' => $request->type_of_work,
            'work_location' => $request->work_location,
            'location' => $request->location,
            'location_coordinates' => $request->location_coordinates,
            'property_size' => $request->property_size,
            'site_detail' => $request->site_detail,
            'is_parking_access' => $request->is_parking_access,
            'area_coordinates' => $request->area_coordinates,
            'services_types_json' => $request->services_types_json,
        ]);
        alert('Property has saved successfully');
        return redirect()->route('garden_help_getProperties');
    }

    public function update(Request $request, $id) {
        $property = CustomerProperty::find($id);
        if (!$property) {
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
            'services_types_json' => 'required',
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
            'services_types_json' => $request->services_types_json,
        ]);
        alert('Property has updated successfully');
        return redirect()->route('garden_help_getProperties');
    }

    public function delete($id) {
        $property = CustomerProperty::find($id);
        if (!$property) {
            alert()->error('The Job ID was invalid.');
            return redirect()->back();
        }
        $property->delete();
        alert('Property has deleted successfully');
        return redirect()->route('garden_help_getProperties');
    }
}
