<?php

namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function getOrdersTable()
    {
        return view('admin.doorder.orders');
    }
}
