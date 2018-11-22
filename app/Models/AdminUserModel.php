<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUserModel extends Model
{
    protected $table = 'admin_user';  //定义用户表名称
    public $timestamps = false;

    public function fetchByUsername($username)
    {
        $data = $this->where('username',$username)
            ->first();
        if(!$data)
        {
            return false;
        }

        return $data;
    }

    /**
     * 生成登陆密码
     * @param string $pwd 原始密码
     * @param string $encrypt 混淆字符
     * @return string
     */
    public function create_password($pwd, $encrypt = '') {
        if(empty($encrypt)) $encrypt = random (6);
        return md5($pwd.$encrypt);
    }

    /**
     * 随机字符串
     * @param int $length 长度
     * @param int $numeric 类型(0：混合；1：纯数字)
     * @return string
     */
    function random($length, $numeric = 0) {
        $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
        if($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }
}
