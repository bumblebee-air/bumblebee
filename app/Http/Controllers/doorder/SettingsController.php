<?php
namespace App\Http\Controllers\doorder;

use App\Client;
use App\ClientSetting;
use App\CustomNotification;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{

    public function getSettings()
    {
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        $client_setting = $the_client->setting;
        $adminsData = [];
        $callCenterOptions = [];
        $savedNotificationsData = [];
        $admins = User::where('user_role', 'client')->whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })
            ->get();
        $savedNotifications = CustomNotification::whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })->get();
        foreach ($admins as $admin) {
            $adminsData[] = [
                'id' => $admin->id,
                'label' => $admin->name,
                'customLabel' => "Admin, $admin->name"
            ];
        }
        foreach ($savedNotifications as $notification) {
            $savedNotificationsData[] = [
                'id' => $notification->id,
                'customNotification' => (bool) $notification->is_active,
                'notification_type' => $notification->type,
                'notification_name' => $notification->name,
                'notification_channel' => $notification->channel,
                'phone_number' => json_decode($notification->send_to, true),
                'email' => json_decode($notification->send_to, true),
                'user_type' => $notification->send_to,
                'notification_content' => $notification->content,
            ];
        }
        return view('admin.doorder.settings.index', [
            'adminOptions' => json_encode($adminsData),
            'callCenterOptions' => json_encode($callCenterOptions),
            'savedNotifications' => ($savedNotificationsData),
            'client_setting' => $client_setting
        ]);
    }

    public function postSaveNotification(Request $request)
    {
        $this->validate($request, [
            'notification_name0' => 'required',
            'notification_type0' => 'required',
            'notification_channel0' => 'required',
            'notification_content0' => 'required',
            'customNotification0' => 'required'
        ]);
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        CustomNotification::whereHas('client', function ($q) use ($the_client) {
            $q->where('name', $the_client->name);
        })->delete();
        for ($i = 0; $i < $request->indexes; $i ++) {
            $send_to = [];
            if ($request["notification_channel$i"] == 'email' || $request["notification_channel$i"] == 'sms') {
                $contacts = $request["notification_channel$i"] == 'email' ? $request["email$i"] : $request["phone_number$i"];
                foreach ($contacts as $contact) {
                    $send_to[] = [
                        'value' => $contact
                    ];
                }
                $send_to = json_encode($send_to);
            } else {
                $send_to = $request["user_type$i"];
            }

            $customNotification = new CustomNotification();
            $customNotification->name = $request["notification_name$i"];
            $customNotification->type = $request["notification_type$i"];
            $customNotification->channel = $request["notification_channel$i"];
            $customNotification->send_to = $send_to;
            $customNotification->content = $request["notification_content$i"];
            $customNotification->client_id = $client_id;
            $customNotification->is_active = $request['customNotification0'] == 'true';
            $customNotification->save();
        }
        alert()->success('Notifications saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }

    public function postSaveStripeApi(Request $request)
    {
        $current_user = auth()->user();
        $client_id = ($current_user->client != null) ? $current_user->client->client_id : null;
        $the_client = Client::find($client_id);
        $client_setting = $the_client->setting;
//        dd($request->all());
        if ($request->has('retailerAutomaticCharging')) {
            $check_if_deliverer_payout_exists = $client_setting->where('name', 'day_of_retailer_charging');
            if (count($check_if_deliverer_payout_exists) > 0) {
             $deliverer_payout = $check_if_deliverer_payout_exists->first();
             $deliverer_payout->update([
                 'the_value' => $request->dayOfMonth
             ]);
            } else {
             ClientSetting::create([
                 'name' => 'day_of_retailer_charging',
                 'client_id' => $the_client->id,
                 'the_value' => $request->dayOfMonth,
                 'display_name' => 'The Schedule datetime'
             ]);
            }
        } else {
         ClientSetting::where('client_id', $the_client->id)->where('name', 'day_of_retailer_charging')->delete();
        }
        if ($request->has('delivererPayout')) {
        $check_if_deliverer_payout_exists = $client_setting->where('name', 'day_time_of_driver_charging');
        if (count($check_if_deliverer_payout_exists) > 0) {
         $deliverer_payout = $check_if_deliverer_payout_exists->first();
         $deliverer_payout->update([
             'the_value' => "$request->weekday 00:00"
         ]);
        } else {
         ClientSetting::create([
             'name' => 'day_time_of_driver_charging',
             'client_id' => $the_client->id,
             'the_value' => "$request->weekday 00:00",
             'display_name' => 'The Schedule datetime'
         ]);
        }
        } else {
        ClientSetting::where('client_id', $the_client->id)->where('name', 'day_time_of_driver_charging')->delete();
        }
        alert()->success('Stripe settings saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
}
