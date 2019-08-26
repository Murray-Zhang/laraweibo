<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //过滤动作
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show', 'create', 'store','index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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
        //判断用户授权
        $this->authorize('update', $user);
        return view('users/edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        //判断用户授权
        $this->authorize('update', $user);

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


    //用户列表展示页
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('info', '删除用户成功');
        return back();
    }
}
