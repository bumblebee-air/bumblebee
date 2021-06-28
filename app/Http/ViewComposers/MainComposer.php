<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\View\View;

class MainComposer
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function compose(View $view)
    {
        $guard_name = '';
        foreach(array_keys(config('auth.guards')) as $a_guard){
            if(auth()->guard($a_guard)->check()){
                $guard_name = $a_guard;
                break;
            }
        }
        $view->with('user', $this->user);
        $view->with('guard_name', $guard_name);
    }
}