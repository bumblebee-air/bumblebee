<?php

namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashobardController extends Controller
{
    public function index() {
        return view('admin.doorder.dashboard');
    }
}
