<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Order;
use App\Retailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CountryFilterController extends Controller
{
    public function setCountry(Request $request)
    {
        // dd("change country " . $request->get('country'));
        Session::put('current_country_filter', $request->get('country'));

        return response()->json([
            "message" => "Sussess " . $request->get('country'),
        ]);
    }

    public function getCountryList(Request $request)
    {
        $countryList = [[
            'id' => 'All',
            'label' => "View all",

        ], [
            'id' => 'ireland',
            'label' => "Ireland",
            'children' => [
                [
                    'id' => 'Dublin',
                    'label' => "Dublin"
                ], [
                    'id' => 'Limerick',
                    'label' => "Limerick"
                ]
            ]
        ], [
            'id' => 'UK',
            'label' => "UK",
            'children' => [
                [
                    'id' => 'London',
                    'label' => "London"
                ], [
                    'id' => 'Bristol',
                    'label' => "Bristol"
                ], [
                    'id' => 'Liverpool',
                    'label' => "Liverpool"
                ], [
                    'id' => 'Birmingham',
                    'label' => "Birmingham"
                ], [
                    'id' => 'Manchester',
                    'label' => "Manchester"
                ],
            ]
        ]];
        return response()->json([
            "country_list" =>   json_encode($countryList),
        ]);
    }
}
