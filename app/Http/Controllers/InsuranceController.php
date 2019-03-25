<?php

namespace App\Http\Controllers;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use Twilio\Rest\Client;

class InsuranceController extends Controller
{
    public function __construct(){

    }

    public function getInsuranceDashboard(){
        return view('insurance.dashboard');
    }
}