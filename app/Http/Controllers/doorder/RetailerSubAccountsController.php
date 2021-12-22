<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Retailer;
use App\Http\Controllers\Controller;

class RetailerSubAccountsController extends Controller
{

    public function postAddRetailerUser(Request $request)
    {
        // dd($request);
        alert()->success('User has been added successfully');
        return redirect()->back();
    }

    public function postEditRetailerUser(Request $request)
    {
        // dd($request);
        alert()->success('User has been updated successfully');
        return redirect()->back();
    }

    public function postDeleteRetailerUser(Request $request)
    {
        // dd($request);
        alert()->success('User has been deleted successfully');
        return redirect()->back();
    }

    public function postDeleteRetailerSubaccount(Request $request)
    {
        // dd($request);
        alert()->success('Subaccount has been deleted successfully');
        return redirect()->back();
    }

    public function getAddRetailerSubAccount($client_name, $retailer_id)
    {
        return view('admin.doorder.retailers.sub_accounts.add_sub_account', [
            'retailer_id' => $retailer_id
        ]);
    }

    public function postAddRetailerSubAccount(Request $request)
    {
     //    dd($request);
        alert()->success('Sub-account has been updated successfully');
        return redirect()->back();
    }

    public function getEditRetailerSubAccount($client_name, $retailer_id, $id)
    {
       // dd('edit subaccount ' . $retailer_id . ' ' . $id);
        $retailer = Retailer::find($id);
        if (! $retailer) {
            // abort(404);
            alert()->error('Retailer not found!');
            return redirect()->back();
        }

        return view('admin.doorder.retailers.sub_accounts.edit_sub_account', [
            'account' => $retailer,
            'retailer_id' => $retailer_id
        ]);
    }
    public function postEditRetailerSubAccount(Request $request)
    {
        dd($request->all());
    }
}

