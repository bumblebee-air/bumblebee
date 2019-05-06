<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twilio\Jwt\AccessToken;

class TwilioAccessTokenProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AccessToken::class, function ($app) {
            $TWILIO_ACCOUNT_SID = env('TWILIO_SID','');
            $TWILIO_API_KEY = env('TWILIO_API_KEY','');
            $TWILIO_API_SECRET = env('TWILIO_API_SECRET','');

            if($TWILIO_ACCOUNT_SID=='' || $TWILIO_API_KEY=='' || $TWILIO_API_SECRET=='')
                return null;

            $token = new AccessToken(
                $TWILIO_ACCOUNT_SID,
                $TWILIO_API_KEY,
                $TWILIO_API_SECRET,
                3600
            );

            return $token;
            }
        );
    }
}
