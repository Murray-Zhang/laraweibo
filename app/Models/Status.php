<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['content'];
    //所属用户
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
