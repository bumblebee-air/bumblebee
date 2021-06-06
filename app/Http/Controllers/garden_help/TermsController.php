<?php
namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use App\TermAndPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    
    public function index()
    {
        return view('admin.garden_help.terms_privacy');
    }
    
    public function save(Request $request,$client)
    {
        /*$this->validate($request, [
            'termsContractor' => 'required',
            'privacyContractor' => 'required',
            'termsCustomer' => 'required',
            'privacyCustomer' => 'required',
        ]);*/
        //Contractor
        $terms_policies_contractor = TermAndPolicy::where('type','=','contractor')->first();
        if(!$terms_policies_contractor) {
            $terms_policies_contractor = new TermAndPolicy();
            $terms_policies_contractor->type = 'contractor';
        }
        if($request->hasFile('termsContractor')) {
            $terms_policies_contractor->terms = $request->file('termsContractor')->store('uploads/terms_and_policies');
        }
        if($request->hasFile('privacyContractor')) {
            $terms_policies_contractor->policy = $request->file('privacyContractor')->store('uploads/terms_and_policies');
        }
        $terms_policies_contractor->save();

        //Customer
        $terms_policies_customer = TermAndPolicy::where('type','=','customer')->first();
        if(!$terms_policies_customer) {
            $terms_policies_customer = new TermAndPolicy();
            $terms_policies_customer->type = 'customer';
        }
        if($request->hasFile('termsCustomer')) {
            $terms_policies_customer->terms = $request->file('termsCustomer')->store('uploads/terms_and_policies');
        }
        if($request->hasFile('privacyCustomer')) {
            $terms_policies_customer->policy = $request->file('privacyCustomer')->store('uploads/terms_and_policies');
        }
        $terms_policies_customer->save();

        alert()->success('Files uploaded successfully');
        return redirect()->route('garden_help_getTermsPrivacy', 'garden_help');
    }
}
