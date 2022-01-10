<?php


namespace App\Helpers;


use App\Mail\GardenHelpUserNotificationEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class GardenHelpUsersNotificationHelper {

    public static function notifyUser(User $user, $body, $type = 'sms') {
        $type == 'sms' ? self::notifyBySMS($user, $body) : self::notifyByEmail($user, $body);
    }

    protected static function notifyByEmail($to, $body, $from = 'GardenHelp') {
        Mail::to($to->email)->send(new GardenHelpUserNotificationEmail($body, $to->name));
    }

    protected static function notifyBySMS($to, $body, $from = 'GardenHelp') {
        TwilioHelper::sendSMS($from, $to->phone, $body);
    }
}