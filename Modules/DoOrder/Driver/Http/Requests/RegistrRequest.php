<?php

namespace Modules\DoOrder\Driver\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users,phone',
            'contact_through' => 'required',
            'birthdate' => 'required',
            'address' => 'required',
            'pps_number' => 'required',
            'emergency_contact_name' => 'required',
            'emergency_contact_number' => 'required',
            'transport_type' => 'required',
            'max_package_size' => 'required',
            'work_location' => 'required',
            'proof_id' => 'required',
            'proof_address' => 'required',
        ];
    }
}
