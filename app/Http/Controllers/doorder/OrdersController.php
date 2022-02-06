<?php
namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\TwilioHelper;
use App\Imports\OrdersImport;
use App\JobComment;
use App\Order;
use App\Retailer;
use App\User;
use App\UserFirebaseToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;
use function GuzzleHttp\json_decode;

class OrdersController extends Controller
{

    public function getOrdersTable()
    {
        if (auth()->user()->user_role == 'retailer') {
            $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->where('is_archived', false)
                ->where('status', '!=', 'delivered')
                ->orderBy('id', 'desc')
                ->paginate(20);
        } else {
            $orders = Order::where('is_archived', false)->where('status', '!=', 'delivered')
                ->orderBy('id', 'desc')
                ->paginate(20);
        }

        // $events=[];
        // foreach ($orders as $order){
        // $events[] = [
        // 'id' => $order->id,
        // 'start' => $order->created_at,
        // 'className' => 'orderStatusCalendar '. $order->status .'Status',
        // 'title' => $order->retailer_name,
        // 'status'=> $order->status,
        // 'retailer_id'=>$order->retailer_id
        // ];
        // }

        $retailers = Retailer::where('status', 'completed')->get();

        foreach ($orders as $order) {
            $order->time = $order->created_at->format('d M y H:i A');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
            $order->fulfilment_date = $order->fulfilment_date ? Carbon::createFromFormat('Y-m-d H:i:s', $order->fulfilment_date)->format('d-m-Y H:i A') : Null;
        }
        return view('admin.doorder.orders', [
            'orders' => $orders,
            'retailers' => $retailers
        ]);
    }

    public function getCalendarOrdersEvents(Request $request)
    {
        $start_date = Carbon::createFromTimestamp($request->start_date);
        $end_date = Carbon::createFromTimestamp($request->end_date);

        $orders = Order::whereDate('created_at', '>=', $start_date->toDateString())->whereDate('created_at', '<=', $end_date->toDateString())
            ->get();

        $events = [];
        foreach ($orders as $order) {
            $events[] = [
                'id' => $order->id,
                'start' => $order->created_at,
                'className' => 'orderStatusCalendar ' . $order->status . 'Status',
                'title' => $order->retailer_name,
                'status' => $order->status,
                'retailer_id' => $order->retailer_id
            ];
        }

        return response()->json([
            'events' => json_encode($events),
            'startDate' => $start_date,
            'endDate' => $end_date
        ]);
    }

    public function addNewOrder()
    {
        $pickup_addresses = [];
        $user_profile = auth()->user()->retailer_profile;
        if ($user_profile) {
            $pickup_addresses = json_decode($user_profile->locations_details, true);
        }
        return view('admin.doorder.add_order', with([
            'pickup_addresses' => $pickup_addresses
        ]));
    }

    public function saveNewOrder(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'customer_lat' => 'required',
            'customer_lon' => 'required',
            'pickup_address' => 'required',
            'fulfilment_date' => 'required',
            // 'deliver_by' => 'required',
            'fragile' => 'required'
        ]);
        $current_user = auth()->user();
        $retailer_profile = $current_user->retailer_profile;
        // $fulfill_start = Carbon::now();
        // $fulfill_end = Carbon::now()->setTimeFromTimeString($request->fulfilment);
        // $is_not_next_day = $fulfill_end->diff($fulfill_start)->invert;
        // if(!$is_not_next_day){
        // $fulfill_end->addDay();
        // }
        // $fulfill_time = $fulfill_end->diffInMinutes($fulfill_start);
        $order = Order::create([
            'customer_name' => "$request->first_name $request->last_name",
            'order_id' => random_int(000001, 999999),
            'customer_email' => $request->email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_address_lat' => $request->customer_lat,
            'customer_address_lon' => $request->customer_lon,
            'eircode' => $request->eircode,
            'pickup_address' => ($request->pickup_address == 'Other') ? $request->pickup_address_alt : $request->pickup_address,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lon' => $request->pickup_lon,
            // 'fulfilment' => $fulfill_time,
            'fulfilment_date' => Carbon::createFromFormat('m/d/Y H:i A', $request->fulfilment_date),
            'notes' => $request->notes,
            'deliver_by' => $request->deliver_by,
            'fragile' => $request->fragile,
            'retailer_name' => ($retailer_profile != null) ? $retailer_profile->name : $current_user->name,
            'retailer_id' => ($retailer_profile != null) ? $retailer_profile->id : '0',
            'status' => 'pending',
            'weight' => $request->weight,
            'dimensions' => $request->dimensions
        ]);

        Redis::publish('doorder-channel', json_encode([
            'event' => 'new-order' . '-' . env('APP_ENV', 'dev'),
            'data' => [
                'id' => $order->id,
                'time' => $order->created_at->format('h:i'),
                'order_id' => $order->order_id,
                'retailer_name' => $order->retailer_name,
                'status' => $order->status,
                'driver' => $order->orderDriver ? $order->orderDriver->name : 'N/A',
                'pickup_address' => $order->pickup_address,
                'customer_address' => $order->customer_address,
                'created_at' => $order->created_at
            ]
        ]));
        CustomNotificationHelper::send('new_order', $order->id);
        alert()->success('Your order saved successfully');
        return redirect()->back();
    }

    public function getSingleOrder($client_name, $id)
    {
        if (auth()->user()->user_role == 'retailer') {
            $order = Order::where('retailer_id', auth()->user()->retailer_profile->id)->where('id', $id)->first();
        } else {
            $order = Order::find($id);
        }

        if (! $order) {
            alert()->error('No order was found!');
            return redirect()->back();
        }
        // dd($order);
        $accepted_deliverers = DriverProfile::where('is_confirmed', '=', 1)->get();
        /*
         * $user_ids = [];
         * foreach($accepted_deliverers as $deliverer){
         * $user_ids[] = $deliverer->user_id;
         * }
         * //$available_drivers = User::where('user_role','=','driver')->get();
         * $available_drivers = User::whereIn('id',$user_ids)->get();
         */
        $customer_name = explode(' ', $order->customer_name);
        $first_name = $customer_name[0];
        $last_name = isset($customer_name[1]) ? $customer_name[1] : '';
        $order->first_name = $first_name;
        $order->last_name = $last_name;
        return view('admin.doorder.single_order', [
            'order' => $order,
            'available_drivers' => $accepted_deliverers
        ]);
    }

    public function assignDriverToOrder(Request $request)
    {
        // dd($request->all());
        $order_id = $request->get('order_id');
        $selected_drivers = $request->get('selected-driver');
        $order = Order::find($order_id);
        // $send_to_all = $driver_id=='all';
        $driver = null;
        $driver_ids = [];
        $old_driver = null;
        if (! $order) {
            alert()->error('No order was found!');
            return redirect()->back();
        }
        $drivers_count = count($selected_drivers);
        if ($drivers_count < 1) {
            alert()->error('No drivers were selected!');
            return redirect()->back();
        }
        /*
         * if(!$send_to_all) {
         * $driver = User::where('id', '=', $driver_id)->where('user_role', '=', 'driver')->first();
         * $old_driver = $order->orderDriver;
         * if(!$driver) {
         * alert()->error('This driver is invalid!');
         * return redirect()->back();
         * }
         * $order->driver = $driver_id;
         * $order->status = 'assigned';
         * $order->driver_status = 'assigned';
         * $order->save();
         * $driver_ids[] = $driver_id;
         * }
         * if($send_to_all){
         * //Get all accepted drivers
         * $driver_ids = DriverProfile::where('is_confirmed','=',1)->get()->pluck('user_id')->toArray();
         * $notification_message = "Order #$order->order_id has been added to the available orders list";
         * $sms_message = "Hi, a new order #$order->order_id has been added to the available orders list";
         * } else {
         * $notification_message = "Order #$order->order_id has been assigned to you";
         * $sms_message = "Hi $driver->name, there is an order assigned to you, please open your app. ".
         * url('driver_app#/order-details/'.$order->id);
         * }
         */
        $notification_message = '';
        $sms_message = '';
        foreach ($selected_drivers as $selected_driver) {
            $driver = User::where('id', '=', $selected_driver)->where('user_role', '=', 'driver')->first();
            $old_driver = $order->orderDriver;
            if ($drivers_count == 1) {
                if (! $driver) {
                    alert()->error('This driver is invalid!');
                    return redirect()->back();
                }
                $order->driver = $selected_driver;
                $order->status = 'assigned';
                $order->driver_status = 'assigned';
                $order->save();
                $notification_message = "Order #$order->order_id has been assigned to you";
                $sms_message = "Hi $driver->name, there is an order assigned to you, please open your app. " . url('driver_app#/order-details/' . $order->id);
            } else {
                $notification_message = "Order #$order->order_id has been added to the available orders list";
                $sms_message = "Hi, a new order #$order->order_id has been added to the available orders list";
                $order->status = 'ready';
                $order->driver = null;
                $order->driver_status = null;
                $order->save();
            }
            $driver_ids[] = $selected_driver;
        }
        // Send Assignment Notification
        $user_tokens = UserFirebaseToken::whereIn('user_id', $driver_ids)->get()
            ->pluck('token')
            ->toArray();
        if (count($user_tokens) > 0) {
            self::sendFCM($user_tokens, [
                'title' => 'Order assigned',
                'message' => $notification_message,
                'order_id' => $order->id
            ]);
        }
        // SMS Assignment Notification
        if ($drivers_count > 1) {
            foreach ($driver_ids as $an_id) {
                $user_profile = User::find($an_id);
                if ($user_profile) {
                    TwilioHelper::sendSMS('DoOrder', $user_profile->phone, $sms_message);
                }
            }
            alert()->success("The accepted drivers have been notified about the order successfully");
        } else {
            TwilioHelper::sendSMS('DoOrder', $driver->phone, $sms_message);
            // Sending message to the old driver
            if ($old_driver) {
                TwilioHelper::sendSMS('DoOrder', $old_driver->phone, "Hi $old_driver->name, We need to inform you that the order #$order->order_id is no longer available.");
            }
            alert()->success("The order has been successfully assigned to $driver->name");
        }
        return redirect()->to('doorder/orders');
    }

    public function updateOrder(Request $request)
    {
        $order_id = $request->get('order_id');
        $order_status = $request->get('order_status');
        $comment = $request->get('comment');
        $order = Order::find($order_id);
        if (! $order) {
            alert()->error('There is no order with this id.');
            return redirect()->back();
        }
        $order->status = $order_status;
        $order->driver_status = $order_status;
        if ($order_status == 'not_delivered') {
            $order->is_archived = true;
        }
        $order->save();
        if ($comment) {
            JobComment::create([
                'comment' => $comment,
                'job_id' => $order->id,
                'job_model' => 'App\Order',
                'user_id' => $request->user()->id
            ]);
        }
        alert()->success("The order has been updated successfully ");
        return redirect()->to('doorder/orders');
    }

    public function getOrdersHistoryTable(Request $request)
    {
        // if (auth()->user()->user_role == 'retailer') {
        // $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->orderBy('id', 'desc')->paginate(20);
        // } else {
        // $orders = Order::where('is_archived', false)->where('status', '!=', 'delivered')
        // ->orderBy('id', 'desc')
        // ->paginate(20);
        // }
        $orders = Order::query();
        $orders = $orders->where('is_archived', true);
        if (auth()->user()->user_role == 'retailer') {
            $orders = $orders->where('retailer_id', auth()->user()->retailer_profile->id);
        } else {}

        if ($request->has('from')) {
            $orders = $orders->whereDate('created_at', '>=', $request->from);
        }

        if ($request->has('to')) {
            $orders = $orders->whereDate('created_at', '<=', $request->to);
        }
        $orders = $orders->with('comments')->paginate(50);
        foreach ($orders as $order) {
            $order->time = $order->created_at->format('d M y');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
        }

        if ($request->has('export')) {
            // export
        } else {
            return view('admin.doorder.orders_history', [
                'orders' => $orders
            ]);
        }
    }

    public function importOrders()
    {
        $pickup_addresses = [];
        $user_profile = auth()->user()->retailer_profile;
        if ($user_profile) {
            $pickup_addresses = json_decode($user_profile->locations_details, true);
        }
        return view('admin.doorder.upload_orders', [
            'pickup_addresses' => $pickup_addresses
        ]);
    }

    public function postImportOrders(Request $request)
    {
        $current_user = \Auth::user();
        $retailer_profile = Retailer::where('user_id', '=', $current_user->id)->first();
        if (! $retailer_profile) {
            alert()->error('No retailer profile found!');
            return redirect()->back();
        }
        $address = null;
        if ($request->address) {
            $address = json_decode($request->address, true);
        } else {
            $retailer_locations = json_decode($retailer_profile->locations_details, true);
            $address = $retailer_locations[0];
        }
        Excel::import(new OrdersImport($retailer_profile->id, $address), $request->file('orders-file'));
        alert()->success('The orders have been imported successfully');
        return redirect()->to('doorder/orders');
    }

    public function deleteOrder(Request $request)
    {
        $this->validate($request, [
            'orderId' => 'required|exists:orders,id'
        ]);
        Order::find($request->orderId)->delete();
        alert()->success('The order deleted successfully');
        return redirect()->to('doorder/orders');
    }

    public function printLabel($client_name, $id)
    {
        // dd("print label ". $id);
        $order = Order::find($id);

        return view('admin.doorder.print_label_order', [
            'order' => $order
        ]);
    }

    public function optimizeOrdersRoute()
    {
        $order_ids = '10,26,36';
        // dd(json_decode('[' . $order_ids . ']', true));
        $order_ids = json_decode('[' . $order_ids . ']', true);
        $orders = Order::whereIn('id', $order_ids)->get();
        $orders_data = [];
        foreach ($orders as $order) {
            $orders_data[] = [
                'order_id' => (string) $order->id,
                'pickup_address' => $order->pickup_address,
                'pickup' => $order->pickup_lat . ',' . $order->pickup_lon,
                'dropdoff_address' => $order->customer_address,
                'dropoff' => $order->customer_address_lat . ',' . $order->customer_address_lon
            ];
        }
        foreach ($orders_data as $key => $an_order) {
            $the_order = $orders->firstWhere('id', $an_order['order_id']);
            $orders_data[$key]['status'] = $the_order->status;
        }
        // dd($orders_data);
        $driver_coordinates = [];
        $driver_coordinates[] = [
            'deliverer_id' => '12',
            'deliverer_coordinates' => '53.425334,-6.231581'
        ];
        // dd(['driver_coordinates'=>$driver_coordinates, 'orders_data'=>$orders_data]);
        $request_body = [
            'deliverers_coordinates' => json_encode($driver_coordinates),
            'orders_address' => json_encode($orders_data)
        ];
        dd($request_body);
        $route_opt_url = env('ROUTE_OPTIMIZE_URL', 'https://afternoon-lake-03061.herokuapp.com') . '/routing_table';
        // dd($route_opt_url);
        $route_optimization_req = Http::post($route_opt_url, $request_body);
        $pot_resp = json_decode($route_optimization_req->body());
        $optimized_route_arr = $pot_resp[0];
        array_shift($optimized_route_arr);
        dd($route_optimization_req->status(), $optimized_route_arr);
    }

    public function getUpdateAddress($client_name, $order_id)
    {
        // dd($order_id);
        $order = Order::find($order_id);

        $retailer_addresses = json_decode($order->retailer->locations_details);
        // dd($retailer_addresses);

        return view('doorder.retailers.orders.update_address', [
            'order_id' => $order_id,
            'order' => $order,
            'retailer_addresses' => $retailer_addresses
        ]);
    }

    public function saveUpdateAddress(Request $request)
    {
        // dd($request->all());
        return redirect('doorder/order/save_address_success');
    }

    public function getUpdateAddressSuccess()
    {
        return view('doorder.retailers.orders.success_update_address');
    }

    public function viewQr($client_name, $id)
    {
        // dd($client_name,$id);
        $name = 'sara';
        $order_number = '123456';
        $qr_str = 'hellooooo';

        return view('admin.doorder.view_qr', [
            'name' => $name,
            'order_number' => $order_number,
            'qr_str' => $qr_str
        ]);
    }
}
