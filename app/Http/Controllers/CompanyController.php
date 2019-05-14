<?php
/**
 * Created by PhpStorm.
 * User: mfayez
 * Date: 11/03/19
 * Time: 03:36 م
 */

namespace App\Http\Controllers;

class CompanyController extends Controller
{
    public function __construct(){

    }

    public function getSendHealthCheck($id){

    }

    public function getSupportForHealthCheck($room){
        return view('support_health_check', compact('room'));
    }
}