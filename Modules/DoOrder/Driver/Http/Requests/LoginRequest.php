<?php

namespace Modules\DoOrder\Driver\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'email' => ['required','email'],
            'password' => ['required','min:6']
        ];
    }
}
