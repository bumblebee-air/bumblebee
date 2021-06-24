<?php
namespace App\Http\Controllers\doorder;

use App\Http\Controllers\Controller;
use function GuzzleHttp\json_encode;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingsController extends Controller
{

    public function getSettings()
    {
        $adminData0 = new OptionData(0, "All", "Admin, All");
        $adminData1 = new OptionData(1, "user 1", "Admin, user 1");
        $adminData2 = new OptionData(2, "user 2", "Admin, user 2");
        $adminData3 = new OptionData(3, "user 3", "Admin, user 3");
        $adminData4 = new OptionData(4, "user 4", "Admin, user 4");

        $adminOptions = array(
            $adminData0,
            $adminData1,
            $adminData2,
            $adminData3,
            $adminData4
        );

        $callCenterData1 = new OptionData(5, "user a", "Call center, user a");
        $callCenterData2 = new OptionData(6, "user b", "Call center, user b");
        $callCenterData3 = new OptionData(7, "user c", "Call center, user c");
        $callCenterData4 = new OptionData(8, "user d", "Call center, user d");

        $callCenterOptions = array(
            $callCenterData1,
            $callCenterData2,
            $callCenterData3,
            $callCenterData4
        );

        $savedNotification1 = new CustomNotificationData(1, 1, "payments", "name 1", "sms", "01276541628", NULL, NULL, "content1");
        $savedNotification2 = new CustomNotificationData(2, 0, "new_retailer", "name 2", "platform", null, NULL, 7, "2222222222");
        $savedNotifications = array($savedNotification1,$savedNotification2);
       // $savedNotifications =array();
       return view('admin.doorder.settings.index', [
            'adminOptions' => json_encode($adminOptions),
            'callCenterOptions' => json_encode($callCenterOptions),
            'savedNotifications'=> ($savedNotifications)
        ]);
    }

    public function postSaveNotification(Request $request)
    {
        // dd($request);
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