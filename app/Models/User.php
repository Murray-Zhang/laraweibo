<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //获取头像从gravatar
    public function gravatar($size = 100)
    {
        $user_email = $this->attributes['email'];
        $hash = md5(strtolower(trim($user_email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}";
    }

    //生成用户模型前生成email验证token
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = Str::random(20);
        });
    }

    //该用户所有文章
    public function statuses()
    {
        return $this->hasMany('App\Models\Status');
    }


    //我的粉丝
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')->withTimestamps();
    }
    //我的关注
    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')->withTimestamps();
    }

    //点击关注
    public function follow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }

        $this->followings()->syncWithoutDetaching($user_ids);
    }
    //取消关注
    public function unfollow($user_ids)
    {
        if(!is_array($user_ids)){
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    //判断当前用户是否关注了某个用户
    public function isFollowing($user_id)
    {
        return $this->followings()->contains($user_id);
    }
}
