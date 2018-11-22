<?php

/**
 * 生成登陆密码
 * @param string $password 原始密码
 * @param string $encrypt 混淆字符
 * @return string
 */
function createPassword($password,$encrypt)
{
    if(empty($encrypt))
    {
        $encrypt = random (6);
    }
    return MD5($encrypt.$password);
}


/**
 * 随机字符串
 * @param int $length 长度
 * @param int $numeric 类型(0：混合；1：纯数字)
 * @return string
 */
function random($length, $numeric = 0)
{
    $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));

    if($numeric)
    {
        $hash = '';
    }
    else
    {
        $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);

        $length--;
    }

    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++)
    {
        $hash .= $seed{mt_rand(0, $max)};
    }
    return $hash;
}

/**
 * 同时更新多条数据
 * @param string $tableName 数据表名
 * @param array $multipleData 更新数据
 * @return bool
 */
function updateBatch($tableName = "", $multipleData = array()){

    if( $tableName && !empty($multipleData) ) {

        // column or fields to update
        $updateColumn = array_keys($multipleData[0]);
        $referenceColumn = $updateColumn[0]; //e.g id
        unset($updateColumn[0]);
        $whereIn = "";

        $q = "UPDATE ".$tableName." SET ";
        foreach ( $updateColumn as $uColumn ) {
            $q .=  $uColumn." = CASE ";

            foreach( $multipleData as $data ) {
                $q .= "WHEN ".$referenceColumn." = ".$data[$referenceColumn]." THEN '".$data[$uColumn]."' ";
            }
            $q .= "ELSE ".$uColumn." END, ";
        }
        foreach( $multipleData as $data ) {
            $whereIn .= "'".$data[$referenceColumn]."', ";
        }
        $q = rtrim($q, ", ")." WHERE ".$referenceColumn." IN (".  rtrim($whereIn, ', ').")";

        // Update
        return DB::update(DB::raw($q));

    } else {
        return false;
    }
}


/**
 * 操作人
 * @return array
 */
function operator(){
    /**
     * @var $adminUser adminUser
     */
    $adminUser = session('adminUser');

    return [
        'id' => $adminUser->id,
        'username' => $adminUser->username
    ];
}

function GetIP(){
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif(!empty($_SERVER["REMOTE_ADDR"])){
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else{
        $cip = "无法获取！";
    }
    return $cip;
}

/**
 * 获取设备名称
 * @param int $deviceid
 * @return array
 */
function getDeviceName($deviceid){

    $list = array(
        1 => '未知',
        2 => 'wap',
        3 => 'wechat',
        4 => 'web',
        5 => 'app',
        6 => '小程序',
    );


    return $list[$deviceid];
}

/**
 * 获取提现方式名称
 * @param int $deviceid
 * @return array
 */
function getWithdrawMethodName($methodid){

    $list = array(
        0 => '未知',
        1 => '银行卡',
        2 => '支付宝',
        3 => '微信',
    );


    return $list[$methodid];
}