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
        $this->validate($request, [
            'termsContractor' => 'required',
            'privacyContractor' => 'required',
            'termsCustomer' => 'required',
            'privacyCustomer' => 'required',
        ]);
        //Contractor
        $terms_policies = new TermAndPolicy();
        $terms_policies->terms = $request->file('termsContractor')->store('uploads/terms_and_policies');
        $terms_policies->policy = $request->file('privacyContractor')->store('uploads/terms_and_policies');
        $terms_policies->type = 'contractor';
        $terms_policies->save();

        //Customer
        $terms_policies = new TermAndPolicy();
        $terms_policies->terms = $request->file('termsCustomer')->store('uploads/terms_and_policies');
        $terms_policies->policy = $request->file('privacyCustomer')->store('uploads/terms_and_policies');
        $terms_policies->type = 'customer';
        $terms_policies->save();

        alert()->success('Files uploaded successfully');
        
        return redirect()->route('garden_help_getTermsPrivacy', 'garden_help');
    }
}
