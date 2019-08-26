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
}
