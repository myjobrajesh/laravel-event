<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    
    /* to display home page view
     */
    public function home() {
        
        // to get total events
        $events   =   \App\Models\Event::with(['location'])->where('status', 'active')->where('start_date', '>=', date('Y-m-d H:i:s'))->get();
        
        return view('layouts.home', compact('events'));
    }
}
