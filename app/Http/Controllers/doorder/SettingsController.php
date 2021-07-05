<?php
namespace App\Http\Controllers\doorder;

use App\CustomNotification;
use App\Http\Controllers\Controller;
use App\User;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{

    public function getSettings()
    {
        $adminsData = [];
        $callCenterOptions = [];
        $savedNotificationsData = [];
        $admins = User::where('user_role', 'client')->whereHas('client', function ($q) {
            $q->where('name', 'DoOrder');
        })->get();
        $savedNotifications = CustomNotification::whereHas('client', function ($q) {
            $q->where('name', 'DoOrder');
        })->get();
        foreach ($admins as $admin) {
            $adminsData[] = ['id' => $admin->id, 'label' => $admin->name,'customLabel'=> "Admin, $admin->name"];
        }
        foreach ($savedNotifications as $notification) {
            $savedNotificationsData[] = [
                'id' => $notification->id,
                'customNotification' => (bool)$notification->is_active,
                'notification_type' => $notification->type,
                'notification_name' => $notification->name,
                'notification_channel' => $notification->channel,
                'phone_number' => $notification->send_to,
                'email' => $notification->send_to,
                'user_type' => $notification->send_to,
                'notification_content' => $notification->content,
            ];
        }
       return view('admin.doorder.settings.index', [
            'adminOptions' => json_encode($adminsData),
            'callCenterOptions' => json_encode($callCenterOptions),
            'savedNotifications'=> ($savedNotificationsData)
        ]);
    }

    public function postSaveNotification(Request $request)
    {
        $this->validate($request, [
            'notification_name0' => 'required',
            'notification_type0' => 'required',
            'notification_channel0' => 'required',
            'notification_content0' => 'required',
            'customNotification0' => 'required',
        ]);
        CustomNotification::whereHas('client', function ($q) {
            $q->where('name', 'DoOrder');
        })->delete();
        for ($i = 0; $i < $request->indexes; $i++) {
            $customNotification = new CustomNotification();
            $customNotification->name = $request["notification_name$i"];
            $customNotification->type = $request["notification_type$i"];
            $customNotification->channel = $request["notification_channel$i"];
            $customNotification->send_to = $request["notification_channel$i"] == 'platform' ? $request["user_type$i"] : ($request["notification_channel$i"] == 'sms' ? $request["phone_number$i"] : $request["email$i"]) ;
            $customNotification->content = $request["notification_content$i"];
            $customNotification->client_id = 2;
            $customNotification->is_active = $request['customNotification0'] == 'true';
            $customNotification->save();
        }
        alert()->success('Notifications saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
}
