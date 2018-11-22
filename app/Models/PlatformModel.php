<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformModel extends Model
{
    protected $table = 'platform';  //定义平台用户表

    public $fillable = ['at','frozen_at'];


}
