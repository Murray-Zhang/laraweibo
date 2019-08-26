<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //所属用户
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
