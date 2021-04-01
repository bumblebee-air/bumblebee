<?php

namespace App\Http\Controllers\doom_yoga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getCustomerRegistrationForm() {
        return view('doom_yoga.customers.registration');
    }
    
    public function postCustomerRegistrationForm(Request $request) {
        
        return view('doom_yoga.customers.registration_card_details');
    }
    
    public function postCustomerRegistrationCardForm(Request $request){
        
        alert()->success('You are registered successfully');
        return redirect()->back();
    }
    
    public function getCustomersRegistrations () {
        
        $registrationsList = collect([
            [
                'dateTime' => '01/09/2020 10:00',
                'firstName' => 'Jane',
                'lastName' => 'Dow',
                'subscriptionType' =>'Monthly subscription',
                'level'=>'Beginner',
                'contactThrough'=>'WhatsApp'
            ],[
                'dateTime' => '01/09/2020 10:00',
                'firstName' => 'Jane',
                'lastName' => 'Dow',
                'subscriptionType' =>'Monthly subscription',
                'level'=>'Beginner',
                'contactThrough'=>'WhatsApp'
            ]
        ]);
        
        return view('admin.doom_yoga.customers.registrations', [
            'registrationsList' => $registrationsList
        ]);
    }
}