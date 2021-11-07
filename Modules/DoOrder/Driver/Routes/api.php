<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'general'
],
    function () {
        Route::get('/new', 'GeneralController@index');
    }
);
