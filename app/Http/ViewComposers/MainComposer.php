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
        $view->with('user', $this->user);
    }
}