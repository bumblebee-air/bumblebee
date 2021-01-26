<?php

namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function getRegistrationForm() {
        return view('garden_help.customers.registration');
    }
}
