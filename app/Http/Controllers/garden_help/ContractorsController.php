<?php

namespace App\Http\Controllers\garden_help;

use App\Contractor;
use App\Mail\ContractorRegistrationMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;

class ContractorsController extends Controller
{
    public function index()
    {
        return view('garden_help.contractors.registration');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'experience_level' => 'required|string',
            'experience_level_value' => 'required|string',
            'age_proof' => 'required_if:experience_level_value,==,2|file',
            'cv' => 'required_if:experience_level_value,==,2|file',
            'job_reference' => 'required_if:experience_level_value,==,2|file',
            'type_of_work_exp' => 'required|string',
            'address' => 'required|string',
            'insurance_document' => 'required|file',
            'has_smartphone' => 'required|boolean',
            'type_of_transport' => 'required|string',
            'charge_type' => 'required_if:experience_level_value,==,3|string',
            'charge_rate' => 'required_if:experience_level_value,==,3|string',
            'has_callout_fee' => 'required_if:experience_level_value,==,3|boolean',
            'callout_fee_value' => 'required_if:experience_level_value,==,3|string',
        ]);
//        dd($request->all());
        //Saving new contractor registration
        $contractor = Contractor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'experience_level' => $request->experience_level,
            'experience_level_value' => $request->experience_level_value,
            'age_proof' => $request->hasFile('age_proof') ? $request->file('age_proof')->store('uploads/contractors_uploads') : null,
            'cv' => $request->hasFile('cv') ? $request->file('cv')->store('uploads/contractors_uploads') : null,
            'job_reference' => $request->hasFile('job_reference') ? $request->file('job_reference')->store('uploads/contractors_uploads') : null,
            'available_equipments' => $request->available_equipments,
            'type_of_work_exp' => $request->type_of_work_exp,
            'address' => $request->address,
            'company_number' => $request->company_number,
            'vat_number' => $request->vat_number,
            'insurance_document' => $request->file('insurance_document')->store('uploads/contractors_uploads'),
            'has_smartphone' => $request->has_smartphone,
            'type_of_transport' => $request->type_of_transport,
            'charge_type' => $request->charge_type,
            'charge_rate' => $request->charge_rate,
            'has_callout_fee' => $request->has_callout_fee,
            'callout_fee_value' => $request->callout_fee_value,
            'rate_of_green_waste' => $request->rate_of_green_waste,
            'green_waste_collection_method' => $request->green_waste_collection_method,
            'social_profile' => $request->social_profiles,
            'website_address' => $request->website,
        ]);

        \Mail::to(env('GH_NOTIF_EMAIL','kim@bumblebeeai.io'))->send(new ContractorRegistrationMail($contractor));
        if($contractor->email!=null && $contractor->email!=''){
            \Mail::to($contractor->email)->send(new ContractorRegistrationMail($contractor));
        }

        alert()->success( 'You registration saved successfully');
        return redirect()->back();
    }

    public function getContractorsRequests() {

        $contractors_requests = Contractor::paginate(20);
        return view('admin.garden_help.contractors.requests', ['contractors_requests' => $contractors_requests]);
    }
}
