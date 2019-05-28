<?php

namespace App\Http\Controllers;
use App\OBD;
use App\ObdToVehicle;
use App\Vehicle;
use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getAddObd(){
        return view('admin.obd_add');
    }

    public function postAddObd(Request $request){
        $the_id = $request->get('the_id');
        $name = $request->get('name');
        $notes = $request->get('notes');
        $obd_device = new OBD();
        $obd_device->the_id = $the_id;
        $obd_device->name = $name;
        $obd_device->notes = $notes;
        $obd_device->save();
        return redirect()->back()->with('success','OBD device was added successfully');
    }

    public function getAddVehicle(){
        return view('admin.vehicle_add');
    }

    public function postAddVehicle(Request $request){
        $vehicle = new Vehicle();
        $vehicle->vehicle_reg = $request->get('vehicle_reg');
        $vehicle->make = $request->get('make');
        $vehicle->model = $request->get('model');
        $vehicle->version = $request->get('version');
        $vehicle->fuel = $request->get('fuel');
        $vehicle->colour = $request->get('colour');
        $vehicle->external_id = $request->get('external_id');
        $vehicle->save();
        return redirect()->back()->with('success','Vehicle was added successfully');
    }

    public function getAddObdToVehicle(){
        $obd_devices = OBD::all();
        $vehicles = Vehicle::all();
        return view('admin.obd_to_vehicle_add',
            compact('obd_devices','vehicles'));
    }

    public function postAddObdToVehicle(Request $request){
        $obd_vehicle = new ObdToVehicle();
        $obd_vehicle->obd_id = $request->get('obd_id');
        $obd_vehicle->vehicle_id = $request->get('vehicle_id');
        $obd_vehicle->save();
        return redirect()->back()->with('success','OBD-Vehicle connection was added successfully');
    }
}