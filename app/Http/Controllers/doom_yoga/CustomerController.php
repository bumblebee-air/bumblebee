<?php
namespace App\Http\Controllers\doom_yoga;

use App\DoomYogaCustomer;
use App\Helpers\StripePaymentHelper;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function getCustomerRegistrationForm(Request $request)
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
        return view('doom_yoga.customers.registration_card_details', [
            'customer_id' => $createNewUser->id,
            'price_id' => $request->price_id
        ]);
    }

    public function postCustomerRegistrationCardForm(Request $request)
    {
        /*
         * Stripe Code
         */
        $customer = DoomYogaCustomer::find($request->customer_id);
        if (! $customer) {
            abort(404);
        }
        // Create Stripe Customer
        $stripe_customer_id = StripePaymentHelper::createCustomer("$customer->first_name $customer->last_name", $customer->email, $request->stripeToken);
        if ($stripe_customer_id) {
            $customer->customer_id = $stripe_customer_id;
            $customer->save();
            // Create customer subscription
            StripePaymentHelper::createCustomerSubscription($stripe_customer_id, $request->price_id);
        }
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

    public function getMusicLibrary()
    {
        return view('doom_yoga.customers.music_library');
    }

    public function getMeditationLibrary()
    {
        $audioData1 = new AudioData(1, "All This Is - Joe L.'s Studio", "02:46", "JLS_ATI");
        $audioData2 = new AudioData(2, "The Forsaken - Broadwing Studio (Final Mix)", "08:31", "BS_TF");
        $audioData3 = new AudioData(3, "All The King's Men - Broadwing Studio (Final Mix)", "05:02", "BS_ATKM");
        
        $audios = array($audioData1,$audioData2,$audioData3);

        return view('doom_yoga.customers.meditation_library', [
            'audios' => json_encode($audios),'mediaPath'=>'//archive.org/download/mythium/'
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

class AudioData
{

    public $track, $name, $length, $file;

    function __construct($track, $name, $length, $file)
    {
        $this->track = $track;
        $this->name = $name;
        $this->length = $length;
        $this->file = $file;
    }
}
