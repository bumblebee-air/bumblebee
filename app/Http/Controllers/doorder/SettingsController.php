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
//        $adminData0 = new OptionData(0, "All", "Admin, All");
//        $adminData1 = new OptionData(1, "user 1", "Admin, user 1");
//        $adminData2 = new OptionData(2, "user 2", "Admin, user 2");
//        $adminData3 = new OptionData(3, "user 3", "Admin, user 3");
//        $adminData4 = new OptionData(4, "user 4", "Admin, user 4");
//
//        $adminOptions = array(
//            $adminData0,
//            $adminData1,
//            $adminData2,
//            $adminData3,
//            $adminData4
//        );
//
//        $callCenterData1 = new OptionData(5, "user a", "Call center, user a");
//        $callCenterData2 = new OptionData(6, "user b", "Call center, user b");
//        $callCenterData3 = new OptionData(7, "user c", "Call center, user c");
//        $callCenterData4 = new OptionData(8, "user d", "Call center, user d");
////
//        $callCenterOptions = array(
//            $callCenterData1,
//            $callCenterData2,
//            $callCenterData3,
//            $callCenterData4
//        );
//
//        $savedNotification1 = new CustomNotificationData(1, 1, "payments", "name 1", "sms", "01276541628", NULL, NULL, "content1");
//        $savedNotification2 = new CustomNotificationData(2, 0, "new_retailer", "name 112313", "platform", null, NULL, 7, "2222222222");
//        $savedNotifications = array($savedNotification1,$savedNotification2);
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
            $adminsData[] = ['id' => $admin->id, 'label' => $admin->name, "Admin, $admin->name"];
        }
        foreach ($savedNotifications as $notification) {
            $savedNotificationsData[] = [
                'id', $notification->id,
                'customNotification' => $notification->is_active,
                'notification_type' => $notification->type,
                'notification_name' => $notification->name,
                'notification_channel' => $notification->channel,
                'phone_number' => $notification->send_to,
                'email' => $notification->send_to,
                'user_type' => $notification->send_to,
                'notification_content' => $notification->content,
            ];
        }
       // $savedNotifications =array();
       return view('admin.doorder.settings.index', [
            'adminOptions' => json_encode($adminsData),
            'callCenterOptions' => json_encode($callCenterOptions),
            'savedNotifications'=> ($savedNotificationsData)
        ]);
    }

    public function postSaveNotification(Request $request)
    {
        for ($i = 0; $i < $request->indexes; $i++) {
            $customNotification = new CustomNotification();
            $customNotification->name = $request["notification_name$i"];
            $customNotification->type = $request["notification_type$i"];
            $customNotification->channel = $request["notification_channel$i"];
            $customNotification->send_to = $request["notification_channel$i"] == 'platform' ? $request["user_type$i"] : ($request["notification_channel$i"] == 'sms' ? $request["phone_number$i"] : $request["email$i"]) ;
            $customNotification->content = $request["notification_content$i"];
            $customNotification->client_id = 2;
            $customNotification->is_active = true;
            $customNotification->save();
        }
        alert()->success('Notifications saved successfully');
        return redirect()->route('doorder_getSettings', 'doorder');
    }
}

class OptionData
{

    public $id, $label, $customLabel;

    public function __construct($id, $label, $customLabel)
    {
        $this->id = $id;
        $this->label = $label;
        $this->customLabel = $customLabel;
    }
}

class CustomNotificationData
{

    public $id, $customNotification, $notification_type, $notification_name, $notification_channel, $phone_number, $email,
        $user_type, $notification_content;

    public function __construct($id, $customNotification, $notification_type, $notification_name, $notification_channel, 
        $phone_number, $email, $user_type, $notification_content)
    {
        $this->id = $id;
        $this->customNotification = $customNotification;
        $this->notification_type = $notification_type;
        $this->notification_name = $notification_name;
        $this->notification_channel = $notification_channel;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->user_type = $user_type;
        $this->notification_content = $notification_content;
    }
}
