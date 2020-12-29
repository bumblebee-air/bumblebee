<?php

namespace App\Http\Controllers\doorder;

use App\Http\Controllers\Controller;
use App\Retailer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RetailerController extends Controller
{
    public function getRetailerRegistrationForm() {
        return view('doorder.retailers.registration');
    }

    public function postRetailerRegistrationForm(Request $request) {
//        dd($request->all());
        $this->validate($request, [
            'company_name' => 'required',
            'company_website' => 'required',
            'business_type' => 'required',
            'number_business_locations' => 'required',
            'locations_details' => 'required',
            'contacts_details' => 'required',
            'stripeToken' => 'required',
        ]);

        $firstContact = json_decode($request->contacts_details)[0];
        $user = new User();
        $user->name = $firstContact->contact_name;
        $user->email = $firstContact->contact_email;
        $user->password = bcrypt(Str::random(6));
        $user->user_role = 'retailer';
        $user->save();

        $retailer = new Retailer();
        $retailer->user_id = $user->id;
        $retailer->name = $request->company_name;
        $retailer->company_website = $request->company_website;
        $retailer->business_type = $request->business_type;
        $retailer->nom_business_locations = $request->number_business_locations;
        $retailer->locations_details = $request->locations_details;
        $retailer->contacts_details = $request->contacts_details;
        $retailer->stripe_token = $request->stripeToken;
        $retailer->save();

        alert()->success('You are registered successfully');
        return redirect()->back();
    }

    public function getRetailerRequests() {
        $retailers_requests = Retailer::paginate(20);
        return view('admin.doorder.retailers.requests', ['retailers_requests' => $retailers_requests]);
    }
}
