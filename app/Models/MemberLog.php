<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLog extends Model
{
    protected $table = 'member_log';  //定义用户表名称
    //批量赋值字段
    protected $fillable = [
        'mid',
        'value',
        'msg',
        'time',
        'type',
        'admin_id',
        'detail',
    ];
    public $timestamps = false;
}
