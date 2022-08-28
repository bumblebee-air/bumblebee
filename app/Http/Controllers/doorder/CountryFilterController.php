<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Models\City;
use App\Models\Country;
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
        $selected_country = $request->get('country');
        //dd("change country " . $selected_country);
        if($selected_country == 'All'){
            Session::forget('country');
            $success_msg = "Reset the current country/city";
        } else {
            Session::put('country', $selected_country);
            $success_msg = "Set the current country/city to " . $selected_country;
        }

        return response()->json([
            "message" => "Success, ".$success_msg,
        ]);
    }

    public function getCountryCityList(Request $request)
    {
        $countries = Country::with('cities')->get();
        $view_all = new Country(['id'=>0, 'name'=>'View all']);
        $countries->prepend($view_all);
        $countryList = $countries->map(function ($item) {
            $country_data = [
                'id' => ($item->name=='View all')? 'All' : $item->name,
                'label' => $item->name,
            ];
            if($item->name!='View all') {
                $country_data['children'] = $item->cities->map(function ($city) {
                    return [
                        'id' => $city->name,
                        'label' => $city->name,
                    ];
                });
            }
            return $country_data;
        });
        /*$countryList = [[
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
        ]];*/
        return response()->json([
            "country_list" => json_encode($countryList),
        ]);
    }
    public function getCountryList(Request $request)
    {
        $countries = Country::all();
        $countryList = $countries->map(function ($item) {
            return [
                'value' => $item->name,
                'label' => $item->name
            ];
        });
        /*$countryList = [[
            'value' => 'Ireland',
            'label' => "Ireland",
        ],
        [
            'value' => 'UK',
            'label' => "UK",
        ]];*/
        return response()->json([
            "country_list" => json_encode($countryList),
        ]);
    }
    public function getCityOfCountryList(Request $request)
    {
        $country = $request->get('country');
        $the_country_entry = Country::where('name','=',$country)->first();
        $the_country_id = $the_country_entry!=null? $the_country_entry->id : 0;
        $the_cities = City::where('country_id','=',$the_country_id)->get();
        $cityList = $the_cities->map(function($item) use($country) {
            return [
                'value' => $item->name,
                'label' => $item->name
            ];
        });
        /*$cityList = [
            [
                'value' => 'city 1',
                'label' => "city 1 ".$country,
            ],
            [
                'value' => 'city 2',
                'label' => "city 2 " . $country,
            ],
        ];*/
        return response()->json([
            "city_list" => json_encode($cityList),
        ]);
    }
}
