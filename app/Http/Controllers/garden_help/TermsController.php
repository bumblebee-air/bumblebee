<?php
namespace App\Http\Controllers\garden_help;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    
    public function index()
    {
       
        return view('admin.garden_help.terms_privacy');
    }
    
    public function save(Request $request,$client)
    {
        
        //dd($request);
        alert()->success('Files uploaded successfully');
        
        return redirect()->route('garden_help_getTermsPrivacy', 'garden_help');
    }
}
