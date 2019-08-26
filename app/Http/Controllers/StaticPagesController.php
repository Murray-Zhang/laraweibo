<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        $feed_items = [];
        if(Auth::check()){
            $feed_items = Auth::User()->statuses()->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('staticpages/home', compact('feed_items'));
    }

    public function help()
    {
        return view('staticpages/help');
    }

    public function about()
    {
        return view('staticpages/about');
    }
}
