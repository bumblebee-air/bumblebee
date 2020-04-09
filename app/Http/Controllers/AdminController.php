<?php

namespace App\Http\Controllers;

use App\OBD;
use App\ObdToVehicle;
use App\Profile;
use App\User;
use App\Vehicle;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use Twilio\Rest\Client;
use Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAddObd()
    {
        return view('admin.obd_add');
    }

    public function postAddObd(Request $request)
    {
        $the_id = $request->get('the_id');
        $name = $request->get('name');
        $notes = $request->get('notes');
        $obd_device = new OBD();
        $obd_device->the_id = $the_id;
        $obd_device->name = $name;
        $obd_device->notes = $notes;
        $obd_device->save();
        return redirect()->back()->with('success', 'OBD device was added successfully');
    }

    public function getEditObd($id)
    {
        $obd_device = OBD::find($id);
        if (!$obd_device) {
            return redirect()->back()->with('error', 'No OBD device was found with this ID');
        }
        return view('admin.obd_edit', compact('obd_device'));
    }

    public function postEditObd(Request $request)
    {
        $id = $request->get('id');
        $the_id = $request->get('the_id');
        $name = $request->get('name');
        $notes = $request->get('notes');
        $obd_device = OBD::find($id);
        $obd_device->the_id = $the_id;
        $obd_device->name = $name;
        $obd_device->notes = $notes;
        $obd_device->save();
        return redirect()->back()->with('success', 'OBD device was edited successfully');
    }

    public function getListObd()
    {
        $obd_devices = OBD::paginate(5);
        //dd($obd_devices);
        return view('admin.obd_list', compact('obd_devices'));
    }

    public function getAddVehicle()
    {
        return view('admin.vehicle_add');
    }

    public function postAddVehicle(Request $request)
    {
        $vehicle = new Vehicle();
        $vehicle->vehicle_reg = $request->get('vehicle_reg');
        $vehicle->make = $request->get('make');
        $vehicle->model = $request->get('model');
        $vehicle->version = $request->get('version');
        $vehicle->fuel = $request->get('fuel');
        $vehicle->colour = $request->get('colour');
        $vehicle->external_id = $request->get('external_id');
        $vehicle->save();
        return redirect()->back()->with('success', 'Vehicle was added successfully');
    }

    public function getEditVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return redirect()->back()->with('error', 'No vehicle was found with this ID');
        }
        return view('admin.vehicle_edit', compact('vehicle'));
    }

    public function postEditVehicle(Request $request)
    {
        $id = $request->get('id');
        $vehicle = Vehicle::find($id);
        $vehicle->vehicle_reg = $request->get('vehicle_reg');
        $vehicle->make = $request->get('make');
        $vehicle->model = $request->get('model');
        $vehicle->version = $request->get('version');
        $vehicle->fuel = $request->get('fuel');
        $vehicle->colour = $request->get('colour');
        $vehicle->external_id = $request->get('external_id');
        $vehicle->save();
        return redirect()->back()->with('success', 'Vehicle was edited successfully');
    }

    public function getListVehicle()
    {
        $vehicles = Vehicle::paginate(5);
        return view('admin.vehicle_list', compact('vehicles'));
    }

    public function getAddObdToVehicle()
    {
        $obd_devices = OBD::all();
        $vehicles = Vehicle::all();
        return view(
            'admin.obd_to_vehicle_add',
            compact('obd_devices', 'vehicles')
        );
    }

    public function postAddObdToVehicle(Request $request)
    {
        $obd_vehicle = new ObdToVehicle();
        $obd_vehicle->obd_id = $request->get('obd_id');
        $obd_vehicle->vehicle_id = $request->get('vehicle_id');
        $obd_vehicle->save();
        return redirect()->back()->with('success', 'OBD-Vehicle connection was added successfully');
    }

    public function getEditObdToVehicle($id)
    {
        $obd_devices = OBD::all();
        $vehicles = Vehicle::all();
        $obd_to_vehicle = ObdToVehicle::find($id);
        if (!$obd_to_vehicle) {
            return redirect()->back()->with('error', 'No obd-vehicle connection was found with this ID');
        }
        return view('admin.obd_to_vehicle_edit', compact(
            'obd_to_vehicle',
            'obd_devices',
            'vehicles'
        ));
    }

    public function postEditObdToVehicle(Request $request)
    {
        $id = $request->get('id');
        $current_obd_to_vehicle = ObdToVehicle::find($id);
        $current_obd_to_vehicle->delete();
        $obd_id = $request->get('obd_id');
        $check_obd = ObdToVehicle::where('obd_id', '=', $obd_id)->first();
        if ($check_obd != null) {
            $check_obd->delete();
        }
        $vehicle_id = $request->get('vehicle_id');
        $check_vehicle = ObdToVehicle::where('vehicle_id', '=', $vehicle_id)->first();
        if ($check_vehicle != null) {
            $check_vehicle->delete();
        }
        $obd_to_vehicle = new ObdToVehicle();
        $obd_to_vehicle->obd_id = $obd_id;
        $obd_to_vehicle->vehicle_id = $vehicle_id;
        $obd_to_vehicle->save();
        return redirect()->to('obd-to-vehicle/list')->with('success', 'OBD-Vehicle connection was updated successfully');
    }

    public function getListObdToVehicle()
    {
        $obd_to_vehicles = ObdToVehicle::with(['vehicle', 'obd'])->paginate(5);
        //dd($obd_to_vehicles);
        return view('admin.obd_to_vehicle_list', compact('obd_to_vehicles'));
    }

    public function getCustomerRegister()
    {
        return view('admin.customer_register');
    }

    public function postCustomerRegister(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'vehicle_reg' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:255', Rule::unique('users')->where('user_role', 'customer')],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $name = $request->get('name');
        $phone = $request->get('phone');
        $user = User::create([
            'name' => $name,
            'phone' => $phone,
            'password' => bcrypt($request->get('password')),
            'user_role' => 'customer'
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'mileage' => '',
            'vehicle_reg' => $request->get('vehicle_reg'),
            'vehicle_make' => $request->get('make'),
            'vehicle_model' => $request->get('model'),
            'vehicle_version' => $request->get('version'),
            'vehicle_fuel' => $request->get('fuel'),
            'vehicle_colour' => $request->get('colour'),
            'vehicle_external_id' => $request->get('external_id'),
        ]);

        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio_number = env('TWILIO_NUMBER', '+447445341335');
        try {
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create(
                "whatsapp:" . $phone,
                [
                    "from" => "whatsapp:+447445341335",
                    "body" => "Hi $name, I'm Bumblebee AIR! Add my number $twilio_number to your Contact List and you can Chat or Send a Voice message on WhatsApp anytime you need help with your vehicle. \n\nWould you like to run a vehicle health check now?"
                ]
            );
            //dd($message);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Customer added successfully');
    }

    public function createCustomer()
    {
        return view('admin.customer.create');
    }

    public function storeCustomer(Request $request)
    {
        $rules = [
            'phone_number' => 'required|unique:users,phone',
            'sending_channel' => 'required',
            'email' => 'nullable|required_if:sending_channel,==,email',
        ];

        $messages = [
            'required_if' => 'The :attribute field is required.',
            'unique' => 'The :attribute is already exist.'
        ];

        $this->validate($request, $rules, $messages);

        $user = new User();
        $user->phone = $request->phone_number;
        $user->email = $request->email;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->user_role = 'customer';
        $user->password = bcrypt('password');
        $user->save();

        // create unique registration link for customer
        $code = $this->generateUniqueCustomerCode($request->phone_number);
        $message = 'Hi dear customer, you can register your account from this link. ' . url('create-customer') . '/' . $code;

        // send registration link to customer
        if ($request->sending_channel === 'email') {
            \Mail::raw($message, function ($message) use ($request) {
                $message->to($request->email)->subject('Registration');
            });
        } else if ($request->sending_channel === 'sms') {
            $sid = env('TWILIO_SID', '');
            $token = env('TWILIO_AUTH', '');

            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create(
                $request->phone_number,
                [
                    "from" => "+447445341335",
                    "body" => $message
                ]
            );
        }

        Session::flash('success', 'Customer was added and registration link sent successfully!');

        return redirect()->back();
    }

    /**
     * Use to generate unique code using customer's phone number
     */
    private function generateUniqueCustomerCode($phone)
    {
        $code = substr(md5(rand(0, 9) . $phone . time()), 0, 32);
        return $code;
    }
}
