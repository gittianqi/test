<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    protected $table = 'member';  //定义用户表名称
    //批量插入字段
    protected $fillable = [
        'username',
        'at',
        'money',
        'mobile',
        'islock',
        'isbind',
        'frozen_at',
        'mobilestatus',
        'platform',
        'platform_mid',
    ];
}
