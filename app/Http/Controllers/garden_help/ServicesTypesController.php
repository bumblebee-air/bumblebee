<?php

namespace App\Http\Controllers\garden_help;

use App\GardenServiceType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServicesTypesController extends Controller
{
    public function getAllServicesTypes() {
        $services_types = GardenServiceType::paginate(20);
        return response()->json($services_types);
    }

    public function addNewServiceType() {
//        return view('');
    }

    public function saveNewServiceType(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'min_hours' => 'required|integer',
            'rate_per_hour' => 'required|integer',
            'max_property_size' => 'required',
        ]);
        GardenServiceType::create([
            'name' => $request->name,
            'min_hours' => $request->min_hours,
            'rate_per_hour' => $request->rate_per_hour,
            'max_property_size' => $request->max_property_size,
        ]);
        alert()->success('Service type has been saved successfully');
        return redirect()->back();
    }

    public function editNewServiceType($id) {
        $service_type = GardenServiceType::find($id);
        if (!$service_type) {
            abort(404);
        }
//        return view();
    }

    public function updateNewServiceType(Request $request, $id) {
        $service_type = GardenServiceType::find($id);
        if (!$service_type) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required',
            'min_hours' => 'required|integer',
            'rate_per_hour' => 'required|integer',
            'max_property_size' => 'required',
        ]);
        $service_type->update([
            'name' => $request->name,
            'min_hours' => $request->min_hours,
            'rate_per_hour' => $request->rate_per_hour,
            'max_property_size' => $request->max_property_size,
        ]);
        alert()->success('Service type has been saved successfully');
//        return view('');
    }
}
