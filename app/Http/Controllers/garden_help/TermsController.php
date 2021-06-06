<?php
namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use App\TermAndPolicy;
use App\UserClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    
    public function index()
    {
        return view('admin.garden_help.terms_privacy');
    }
    
    public function save(Request $request)
    {
        /*$this->validate($request, [
            'termsContractor' => 'required',
            'privacyContractor' => 'required',
            'termsCustomer' => 'required',
            'privacyCustomer' => 'required',
        ]);*/
        $current_user = \Auth::user();
        $user_client = UserClient::where('user_id','=',$current_user->id)->first();
        if(!$user_client){
            alert()->error('There is something wrong with your user configuration, please contact the support');
            return redirect()->back();
        }
        $client_id = $user_client->client_id;
        $general_files_to_upload = 0;
        //Contractor
        $files_to_upload = 0;
        $terms_policies_contractor = TermAndPolicy::where('type','=','contractor')
            ->where('client_id','=',$client_id)->first();
        if(!$terms_policies_contractor) {
            $terms_policies_contractor = new TermAndPolicy();
            $terms_policies_contractor->type = 'contractor';
            $terms_policies_contractor->client_id = $client_id;
        }
        if($request->hasFile('termsContractor')) {
            $terms_policies_contractor->terms = $request->file('termsContractor')->store('uploads/terms_and_policies');
            $files_to_upload++;
        }
        if($request->hasFile('privacyContractor')) {
            $terms_policies_contractor->policy = $request->file('privacyContractor')->store('uploads/terms_and_policies');
            $files_to_upload++;
        }
        if($files_to_upload>0) {
            $terms_policies_contractor->save();
        }
        $general_files_to_upload += $files_to_upload;
        //Customer
        $files_to_upload = 0;
        $terms_policies_customer = TermAndPolicy::where('type','=','customer')
            ->where('client_id','=',$client_id)->first();
        if(!$terms_policies_customer) {
            $terms_policies_customer = new TermAndPolicy();
            $terms_policies_customer->type = 'customer';
            $terms_policies_contractor->client_id = $client_id;
        }
        if($request->hasFile('termsCustomer')) {
            $terms_policies_customer->terms = $request->file('termsCustomer')->store('uploads/terms_and_policies');
            $files_to_upload++;
        }
        if($request->hasFile('privacyCustomer')) {
            $terms_policies_customer->policy = $request->file('privacyCustomer')->store('uploads/terms_and_policies');
            $files_to_upload++;
        }
        if($files_to_upload>0) {
            $terms_policies_customer->save();
        }
        $general_files_to_upload += $files_to_upload;
        if($general_files_to_upload>0) {
            alert()->success('Files uploaded successfully');
        } else {
            alert()->warning('No files were uploaded');
        }
        return redirect()->route('garden_help_getTermsPrivacy', 'garden_help');
    }
}
