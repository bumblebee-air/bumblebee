<?php

namespace App\Http\ViewComposers;

use App\Client;
use Auth;
use Illuminate\View\View;

class SideNavComposer
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function compose(View $view)
    {
        $admin_nav_logo = null;
        $admin_nav_highlight_color = null;
        $admin_nav_background_image = null;
        $user_type = null;
        $client_name = null;
        if($this->user!=null){
            if($this->user->user_role == 'client' || $this->user->user_role == 'retailer'){
                $user_type = $this->user->user_role;
                $client_profile = Client::find($this->user->client->client_id);
                $client_name = $client_profile->name;
                if($client_profile){
                    if($client_profile->logo!=null){
                        $admin_nav_logo = asset($client_profile->logo);
                    }
                    if($client_profile->nav_highlight_color!=null){
                        $admin_nav_highlight_color = asset($client_profile->nav_highlight_color);
                    }
                    if($client_profile->nav_background_image!=null){
                        $admin_nav_background_image = asset($client_profile->nav_background_image);
                    }
                }
            } else if($this->user->user_role == 'retailer') {
                $client_name = $this->user->name;
            }
        }
        $view->with(['user'=>$this->user, 'user_type'=>$user_type,
            'admin_client_name'=>$client_name, 'admin_nav_logo'=>$admin_nav_logo,
            'admin_nav_highlight_color'=>$admin_nav_highlight_color,
            'admin_nav_background_image'=>$admin_nav_background_image]);
    }
}
