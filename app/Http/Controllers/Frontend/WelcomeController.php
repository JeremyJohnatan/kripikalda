<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class WelcomeController
{
    public function index(){
        return view('frontend.dashboard');
    }
}
