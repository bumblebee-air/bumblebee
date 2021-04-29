<?php
namespace App\Http\Controllers\doom_yoga;

use App\DoomYogaCustomer;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function getCustomerRegistrationForm()
    {
        return view('doom_yoga.customers.registration');
    }

    public function postCustomerRegistrationForm(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'level' => 'required',
            'email' => 'required|unique:users',
            'phone_number' => 'required|unique:users,phone',
            'contact_through' => 'required',
            'password' => 'required'
        ]);
        $createNewUser = new User();
        $createNewUser->name = "$request->first_name $request->last_name";
        $createNewUser->email = $request->email;
        $createNewUser->phone = $request->phone_number;
        $createNewUser->user_role = "doomyoga_customer";
        $createNewUser->password = bcrypt($request->password);
        $createNewUser->save();

        DoomYogaCustomer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'level' => $request->level,
            'email' => $request->email,
            'user_id' => $createNewUser->id,
            'phone' => $request->phone_number,
            'contact_through' => json_encode($request->contact_through)
        ]);
        return view('doom_yoga.customers.registration_card_details');
    }

    public function postCustomerRegistrationCardForm(Request $request)
    {
        /*
         * Stripe Code
         */
        alert()->success('You are registered successfully');
        return redirect()->back();
    }

    public function getCustomersRegistrations()
    {

        // $registrationsList = collect([
        // [
        // 'dateTime' => '01/09/2020 10:00',
        // 'firstName' => 'Jane',
        // 'lastName' => 'Dow',
        // 'subscriptionType' =>'Monthly subscription',
        // 'level'=>'Beginner',
        // 'contactThrough'=>'WhatsApp'
        // ],[
        // 'dateTime' => '01/09/2020 10:00',
        // 'firstName' => 'Jane',
        // 'lastName' => 'Dow',
        // 'subscriptionType' =>'Monthly subscription',
        // 'level'=>'Beginner',
        // 'contactThrough'=>'WhatsApp'
        // ]
        // ]);
        $registrationsList = DoomYogaCustomer::paginate(50);

        return view('admin.doom_yoga.customers.registrations', [
            'registrationsList' => $registrationsList
        ]);
    }

    public function getCustomerLogin()
    {
        return view('doom_yoga.customers.login');
    }

    public function postCustomerLogin(Request $request)
    {
        // dd($request);
        return redirect()->route('getCustomerAccount', 'doom-yoga');
    }

    public function getCustomerAccount()
    {
        return view('doom_yoga.customers.account_home');
    }

    public function getVideoLibrary()
    {
        $videoData1 = new VideoData("images/wheat-field.mp4", "images/doom-yoga/doom-yoga-logo.png", "Mental Training", "04 Min 20 Sec");
        // dd($videoData1);
        $videoData2 = new VideoData("images/wheat-field.mp4", "images/doom-yoga/doom-yoga-logo.png", "For Losing Weight", "12 Min 20 Sec");

        $videos = array(
            $videoData1,
            $videoData2,
            $videoData1,
            $videoData2,
            $videoData1,
            $videoData2,
            $videoData1,
            $videoData2
        );

        $categoryData1 = new CategoryData('Category 1', $videos);
        $categoryData2 = new CategoryData('Category 2', $videos);
        $categories = array(
            $categoryData1,
            $categoryData2
        );
        return view('doom_yoga.customers.video_library', [
            'categories' => json_encode($categories)
        ]);
    }
}

class CategoryData
{

    public $title, $videos;

    function __construct($title, $videos)
    {
        $this->title = $title;
        $this->videos = $videos;
    }
}

class VideoData
{

    public $videoUrl, $posterImageUrl, $title, $duration;

    function __construct($videoUrl, $posterImageUrl, $title, $duration)
    {
        $this->videoUrl = $videoUrl;
        $this->posterImageUrl = $posterImageUrl;
        $this->title = $title;
        $this->duration = $duration;
    }
}

