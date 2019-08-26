<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function create()
    {
        return view('users/create');
    }

    public function show(User $user)
    {
        return view('users/show', compact('user'));
    }

    //注册数据提交处理
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //注册之后自动登陆
        Auth::login($user);

        session()->flash('success', '欢迎，您将在这里开启有一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    //个人中心修改页面
    public function edit(User $user)
    {
        return view('users/edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);


        $update_data = [];
        $update_data['name'] = $request->name;
        if($request->password){
            $update_data['password'] = $request->password;
        }
        $user->update($update_data);
        session()->flash('success', '您的个人信息修改成功！');

        return redirect()->route('users.show', $user);
    }
}
