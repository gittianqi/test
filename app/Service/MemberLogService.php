<?php

namespace App\Service;

use App\Models\MemberLog;
use App\Models\MemberModel;
use Illuminate\Support\Facades\DB;

class MemberLogService
{

    public function add($mid, $value, $msg = '', $type = '', $detail = [], $admin_id = 0)
    {
        $log_type = [
            'money',
            'at'
        ];
        if((int)$mid <= 0)
            throw new \exception('数据异常', 51001);
        if(!is_numeric($value))
            throw new \exception('数据错误', 51003);
        if(!in_array($type, $log_type))
            throw new \exception('数据异常', 51001);
        if(!is_array($detail))
            throw new \exception('数据异常', 51003);

        $log['mid'] = $mid;
        $log['value'] = $value;
        $log['msg'] = $msg;
        $log['time'] = time();
        $log['type'] = $type;
        $log['admin_id'] = (int)$admin_id;
        $log['detail'] = json_encode($detail);
        $res = MemberLog::insert($log);
        if (!$res) return false;
        return true;
    }

}