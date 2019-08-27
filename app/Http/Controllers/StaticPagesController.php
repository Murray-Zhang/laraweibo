<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    public function home()
    {
        //获取用户信息
        $user = \App\Models\User::withCount(['statuses', 'followers', 'followings'])->find(Auth::id());
        $feed_items = [];
        if(Auth::check()){
            $feed_items = Auth::User()->feed()->paginate(10);
        }
        return view('staticpages/home', compact('feed_items','user'));
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
