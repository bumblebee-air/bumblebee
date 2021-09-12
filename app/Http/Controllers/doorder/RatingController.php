<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function getRating($client_name,$user_type,$order_id){
      //  dd('rating '.$client_name.' '.$user_type.' '.$order_id);
        
        $user_type_str = $user_type == 1 ? 'retailer' : 'customer'; 
        //user type=1 if retailer, 2 if customer
        
        return view('admin.doorder.rating.index', ['user_type'=>$user_type_str,'order_id'=>$order_id]);
    }
    
    public function saveRating(Request $request) {
        //dd($request);
        
        return redirect('doorder/order/rating_success');
    }
    
    public function getSuccess(){
        return view('admin.doorder.rating.success');
    }
}

