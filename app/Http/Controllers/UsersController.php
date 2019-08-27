<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //过滤动作
    public function __construct()
    {
        // 未登录可以展示的页面
        $this->middleware('auth',[
            'except' => ['show', 'create', 'store','confirmEmail']
        ]);

        //只允许未登录用户访问的动作
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    //用户注册
    public function create()
    {

        return view('users/create');
    }

    //个人中心展示
    public function show(User $user)
    {
        $user = User::withCount(['statuses', 'followers', 'followings'])->find($user->id);
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(30);
        return view('users/show', compact('user', 'statuses'));
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

        //注册之后发送邮件
        $this->sendEmailConfirmationTo($user);

        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
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

    //邮件认证
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success', '激活成功');
        return redirect()->route('users.show',compact('user'));
    }

    //发送邮件给指定用户
    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 Weibo 应⽤！请确认你的邮箱。";
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    //关注列表
    public function followings(User $user)
    {
        $title = $user->name . '关注的人';
        $users = $user->followings()->paginate(10);


        return view('users.show_follow', compact('title', 'users'));
    }
    //粉丝列表
    public function followers(User $user)
    {
        $title = $user->name . '的粉丝';
        $users = $user->followers()->paginate(10);
        return view('users.show_follow', compact('title', 'users'));
    }

    //点击关注
    public function doFollow(User $user)
    {
        $this->authorize('follow', $user);
        $nowUser = Auth::User();

        if (!$nowUser->isFollowing($user->id)) {
            $nowUser->follow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }

    //取消关注
    public function noFollow(User $user)
    {
        $this->authorize('follow', $user);
        $nowUser = Auth::user();
        if ($nowUser->isFollowing($user->id)) {
            $nowUser->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
