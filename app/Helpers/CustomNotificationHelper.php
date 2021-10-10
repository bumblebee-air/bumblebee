<?php


namespace App\Helpers;


use App\CustomNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class CustomNotificationHelper
{
    public static function send($type, $id) {
        $customNotifications = CustomNotification::where('type', $type)
            ->where('is_active','=','1')->get();
        $title = '';
        $url = '';
        switch ($type) {
            case 'new_retailer':
                $title = 'There is a new retailer request.';
                $url = route('doorder_retailers_single_request', ['doorder', $id]);
                break;
            case 'new_deliverer':
                $title = 'There is a new deliverer request.';
                $url = route('doorder_drivers_single_request', ['doorder', $id]);
                break;
            case 'new_order':
                $title = 'There is a new order.';
                $url = route('doorder_singleOrder', ['doorder', $id]);
                break;
            case 'order_completed':
                $title = 'There is an order completed.';
                $url = route('doorder_singleOrder', ['doorder', $id]);
                break;
            case 'collection_delay':
                $title = 'There is an collection delay.';
                $url = '';
                break;
            case 'payments':
                $title = 'There is an new payment';
                $url = '';
                break;
            default:
                $title = 'There is a new custom notification.';
        }
        foreach ($customNotifications as $notification) {
            if ($notification->channel == 'sms') {
                $contacts = json_decode($notification->send_to, true);
                foreach ($contacts as $contact) {
                    TwilioHelper::sendSMS('DoOrder', $contact['value'], $notification->content);
                }
            } else if ($notification->channel == 'email') {
                $contacts = json_decode($notification->send_to, true);
                foreach ($contacts as $contact) {
                    Mail::to($contact['value'])->send(new \App\Mail\CustomNotification($notification->content, $title));
                }
            } else {
                //Platform Notification
                Redis::publish('doorder-channel', json_encode([
                    'event' => 'custom-notification'.'-'.env('APP_ENV','dev'),
                    'data' => [
                        'title' => $title,
                        'url' => $url
                    ]
                ]));
            }
        }
    }
}
