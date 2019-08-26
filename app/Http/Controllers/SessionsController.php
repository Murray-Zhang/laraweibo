<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //只允许未登录用户访问的动做
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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

        if(Auth::attempt($sign_date,$request->has('remember'))){
            if(Auth::user()->activated){
                //登陆成功
                session()->flash('success', '欢迎回来');
                $defaultRoute = route('users.show', [Auth::user()]);
                return redirect()->intended($defaultRoute);
            }else{
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请点击激活邮件激活');
                return redirect('/');
            }
        }else{
            //登陆失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');

            return redirect()->back()->withInput();
        }
    }

    //退出
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
