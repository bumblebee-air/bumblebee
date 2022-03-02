<?php


namespace App\Helpers;


use App\CustomNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class CustomNotificationHelper
{
    public static function send($type, $id, $client = 'DoOrder') {
        $customNotifications = CustomNotification::where('type', $type)
            ->where('is_active','=','1')->whereHas('client', function ($q) use ($client) {
                $q->where('name', $client);
            })->get();
        $title = '';
        $url = '';
        if ($client == 'DoOrder') {
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
                case 'external_store_fulfillment':
                    $title = 'There is an external order has been fulfilled';
                    $url = route('doorder_singleOrder', ['doorder', $id]);
                    break;
                default:
                    $title = 'There is a new custom notification.';
            }
        } else {
            switch ($type) {
                case 'new_customer':
                    $title = 'There is a new customer request.';
                    $url = route('garden_help_getcustomerSingleRequest', ['garden-help', $id]);
                    break;
                case 'new_contractor':
                    $title = 'There is a new contractor request.';
                    $url = route('garden_help_getContractorSingleRequest', ['garden-help', $id]);
                    break;
                case 'payments':
                    $title = 'There is an new payment';
                    $url = '';
                    break;
                case 'new_contractor_bidding_client':
                    $title = 'There is an new contractor bidding';
                    $url = route('garden_help_getSingleJob', ['garden-help', $id]);
                    break;
                default:
                    $title = 'There is a new custom notification.';
            }
        }
        foreach ($customNotifications as $notification) {
            $content = $notification->content;
            if ($url && $notification->channel != 'platform') {
                $content .= ", Please click on the following URL: $url";
            }
            if ($notification->channel == 'sms') {
                $contacts = json_decode($notification->send_to, true);
                foreach ($contacts as $contact) {
                    TwilioHelper::sendSMS($client, $contact['value'], $content);
                }
                if($notification->retailers){
                    $retailers = explode(',',$notification->retailers);
                    foreach ($retailers as $retailer) {
                        TwilioHelper::sendSMS($client, $retailer, $content);
                    }
                }
            } else if ($notification->channel == 'email') {
                $contacts = json_decode($notification->send_to, true);
                foreach ($contacts as $contact) {
                    Mail::to($contact['value'])->send(new \App\Mail\CustomNotification($content, $title, $client));
                }
            } else {
                //Platform Notification
                $channel = $client == 'DoOrder' ? 'doorder-channel' : 'garden-help-channel';
                Redis::publish($channel, json_encode([
                    'event' => 'custom-notification'.'-'.env('APP_ENV','dev'),
                    'data' => [
                        'title' => $title,
                        'url' => $url,
                        'id' => $notification->send_to
                    ]
                ]));
            }
        }
    }
}
