<?php
namespace App\Http\Controllers\doorder;

use App\Order;
use App\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
{
    public function getRating($client_name,$user_type,$order_id){
        //dd('rating '.$client_name.' '.$user_type.' '.$order_id);
        //user type=1 if retailer, 2 if customer
        $user_type_str = ($user_type == 1)? 'retailer' : 'customer';
        //check if there is already a rating for this order by this user type
        $order = Order::find($order_id);
        if(!$order){
            return view('admin.doorder.rating.index', ['error'=>1,
                'error_message'=>'This order was not found!',
                'user_type'=>null,'order_id'=>null]);
        }
        $order_rating = $order->rating()->where('model','=','order')
            ->where('user_type','=',$user_type_str)->first();
        if($order_rating!=null){
            return view('admin.doorder.rating.index', ['error'=>1,
                'error_message'=>'This order has already been rated!',
                'user_type'=>null,'order_id'=>null]);
        }
        return view('admin.doorder.rating.index', ['error'=>0,
            'user_type'=>$user_type_str, 'order_id'=>$order_id]);
    }
    
    public function saveRating(Request $request) {
        //dd($request->all());
        $order_id = $request->get('order_id');
        $rating = $request->get('score');
        $user_type = $request->get('user_type');
        if($rating==null){
            alert()->error('No rating was given, please select the rating from 1 to 5 stars!');
            return redirect()->back();
        }
        if($order_id==null || $user_type==null){
            alert()->error('There was a problem with submitting the rating, please try again!');
            return redirect()->back();
        }
        $order = Order::find($order_id);
        if(!$order){
            alert()->error('This order was not found!');
            return redirect()->back();
        }
        $order_rating = new Rating();
        $order_rating->model = 'order';
        $order_rating->model_id = $order_id;
        $order_rating->user_type = $user_type;
        $order_rating->rating = $rating;
        $order_rating->save();
        return redirect('doorder/order/rating_success');
    }
    
    public function getSuccess(){
        return view('admin.doorder.rating.success');
    }
}

