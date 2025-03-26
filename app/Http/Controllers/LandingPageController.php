<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    function home()
    {
        return view('livewire.pages.components-frontend.index');
    }
}
