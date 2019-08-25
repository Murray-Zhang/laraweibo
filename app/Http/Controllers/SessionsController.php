<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //登陆页面
    public function create()
    {
        return view('sessions/create');
    }

    //验证登陆信息
    public function store(Request $request)
    {
        $sign_date = $this->validate($request,[
            'email' =>'required|email|max:255',
            'password' => 'required|min:6'
        ]);

        if(Auth::attempt($sign_date)){
            //登陆成功
            session()->flash('success', '欢迎回来');
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            //登陆失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');

            return redirect()->back()->withInput();
        }
    }
}
