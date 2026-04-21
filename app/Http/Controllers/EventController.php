<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    function show(){
    return view('event-detail');
    }

    function checkout(){
    return view('checkout');
    }

    function ticket(){
        return view('ticket');
    }
}

