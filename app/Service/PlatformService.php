<?php

namespace App\Service;

use App\Models\PlatformModel;
use App\Models\PlatformSettingModel;
use Illuminate\Support\Facades\DB;

class PlatformService
{
    /**
     * 获取会员列表
     * @param array $arr
     * @return bool
     */
    public function getList($arr = [])
    {
        $arr['platform.platform_id'] = 0;
        $data = DB::table('platform')->where($arr)
            ->leftJoin('platform_setting', function($join){
            $join->on('platform_setting.pid','=','platform.id');
        })->orderBy('platform.id','desc')->get();

        if(!$data)
        {
            $this->msg = '数据为空';
            return false;
        }
        return $data;
    }

    /**
     * 获取某个会员信息
     * @param int  $platformid
     * @return bool
     */
    public function getPlatformInfo($platformid)
    {

        $col = array();
        $col[]= 'platform.*';
        $col[]= 'platform_setting.*';
        $col[]= 'platform_token.access_token';
        $col[]= 'platform_token.timestamp';
        $col[]= 'platform_token.nonce';

        $data = DB::table('platform')
            ->select($col)
            ->where('platform.id', $platformid)
            ->leftJoin('platform_setting', function($join){
                $join->on('platform_setting.pid','=','platform.id');
            })->leftJoin('platform_token',function($join1){
              $join1->on('platform_token.pid','=','platform.id');
            })->orderBy('platform.id','desc')->first();

        if(!$data)
        {
            return false;
        }
        return $data;
    }

    /**
     * 更新数据
     * @param array $data
     * @return bool
     * @throws \exception
     */
    public function update($data = []){

        if((int)$data['id'] < 1)
            throw new \exception('数据异常', 53006);
        if(isset($data['at_type']) && !in_array($data['at_type'], ['-','+']))
            throw new \exception('数据异常', 53006);
        if(isset($data['islock']) && !in_array($data['islock'], [0,1]))
            throw new \exception('数据异常', 53006);


        $admin = session('adminUser');
        $PlatformModel = new PlatformModel();
        $settingmode = new PlatformSettingModel();
        $member = $PlatformModel::find($data['id']);
        if(!$member) throw new \exception('账户不存在', 53007);

        $map = [];
        if(isset($data['islock']))   $map['islock'] = $data['islock'];

        if(isset($data['at_num']) && (int)$data['at_num'] <= 0)
            throw new \exception('请正确填写调整的AT值', 53008);
        if(isset($data['at_num']) && (int)$data['at_num'] > 0){
            $money = ($data['at_type'] == '+') ? $member->at + $data['at_num'] : $member->at - $data['at_num'];
            $map['at'] = max(0, $money);
        }

        $setmap = [];
        $setmap['login_url'] = $data['login_url'];
        $setmap['exchange_url'] = $data['exchange_url'];

        //开启事务
        DB::beginTransaction();
        try{

            //更新平台信息
            $PlatformModel->where('id', $data['id'])->update($map);


            //更新平台设置信息
            $settingmode->where('pid', $data['id'])->update($setmap);


            //平台日志表AT
            $atferat = ($data['at_type'] == '+') ? $member->at + $member->frozen_at + $data['at_num'] : $member->at + $member->frozen_at - $data['at_num'];
            $platlogid = DB::table('platform_log')->insertGetId([
                'pid'=>$data['id'],
                'value'=> floatval($data['at_num']),//变动金额
                'msg'=>'修改平台AT',
                'time'=>time(),
                'type'=>'at',
                'admin_id'=>$admin['id'],
                'detail'=>'{"old_at":'.strval($member->at+$member->frozen_at).
                    ',"change_at":'.$data['at_num'].',"new_at":'. strval(floatval($atferat)).'}',
            ]);

            //子账号锁定处理
            $sublist = $PlatformModel->where('platform_id', $data['id'])->get();
            if (!empty($sublist)){
                $submap = [];
                foreach ($sublist as $k => $v){
                    $submap['islock'] = $data['islock'] ?: 0;
                    $PlatformModel->where('id', $v['id'])->update($submap);
                }
            }

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw new \exception("更新失败",53009);
        }
    }

    /**
     * 添加数据
     * @param array $data
     * @return bool
     * @throws \exception
     */
    public function add($data = [])
    {

        if(empty($data['password']))  throw new \exception('密码不能为空', 53003);
        if(empty($data['at'])) $data['at'] = 0;
        if(!is_numeric($data['at']))  throw new \exception('AT不是数子类型', 53004);

        if(!preg_match("/^1[34578]{1}\d{9}$/",$data['mobile']))
            throw new \exception('手机号码不正确', 53005);
        if ($this->isPlatformExistFieldValue('mobile', $data['mobile'])) {
            throw new \exception('该手机号码已经存在', 53005);
        }


        $data['group_id']=0;
        $data['encrypt'] = random(6);
        $data['password'] = createPassword($data['password'],$data['encrypt']);
        $data['logo'] = '';
        $data['created_at'] = date('Y-m-d H:i:s', time());
        $data['updated_at'] = date('Y-m-d H:i:s', time());

        $PlatformModel = new PlatformModel();
        $PSettingModel = new PlatformSettingModel();

        $setdata = array();
        $setdata['appid'] = 'hyl'.$this->getPlatformUniqueFieldValue('appid',16);
        $setdata['appsecret'] = $this->getPlatformUniqueFieldValue('appsecret',30);

        $setdata['login_url'] = $data['login_url'];
        $setdata['exchange_url'] = $data['exchange_url'];
        $setdata['auth_url'] = '';


        unset($data['login_url'],$data['exchange_url']);

        //开启事务
        DB::beginTransaction();
        try{

            $pid = $PlatformModel::insertGetId($data);
            $setdata['pid'] = $pid;

            $PSettingModel::insert($setdata);

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw new \exception('添加失败',53013);
            return false;
        }

    }

    /**
     * 删除数据
     * @param int $id
     * @return bool
     * @throws \exception
     */
    public function del($id)
    {

        if(empty($id))  throw new \exception('ID不能为空', 53010);

        $PSettingModel = new PlatformSettingModel();
        $PlatformModel = new PlatformModel();
        $platformmember = $PlatformModel::where('id', $id)->first();

        if ($platformmember->islock){
            throw  new \exception('账号处于锁定状态，不能删除', 53011);
        }
        $subaccount = $PlatformModel::where('platform_id', $id)->get()->toArray();
        if (count($subaccount) > 0){
            throw  new \exception('存在子账号不能删除', 53014);
        }



        //开启事务
        DB::beginTransaction();
        try{

            //删除平台账号
            $PlatformModel->where('id', $id)->delete();

            //删除平台设置数据
            $PSettingModel->where('pid', $id)->delete();

            DB::commit();
            return true;

        }catch(\Exception $e){
            DB::rollback();
            throw new \exception('删除账号失败',53015);
            return false;
        }

    }

    /**
     * 判断平台会员指定字段内容是否存在
     * @param string $field
     * @param string $value
     * @return bool
     * @throws \exception
     */
    public function isPlatformExistFieldValue($field, $value)
    {

        if(empty($field))  throw new \exception('验证平台会员字段名称不能为空', 53001);
        if(empty($value))  throw new \exception('验证平台会员字段值不能为空', 53002);

        $data = PlatformModel::where($field,$value)->first();
        if(!$data)
        {
            return false;
        }
        return true;
    }

    /**
     * 判断平台会员指定字段内容是否存在
     * @param string $field
     * @param string $value
     * @return bool
     * @throws \exception
     */
    public function isExistFieldValue($field, $value)
    {

        if(empty($field))  throw new \exception('验证平台会员字段名称不能为空', 53001);
        if(empty($value))  throw new \exception('验证平台会员字段值不能为空', 53002);

        $data = PlatformSettingModel::where($field,$value)->first();
        if(!$data)
        {
            return false;
        }
        return true;
    }

    /**
     * 获取平台会员表特定字段唯一值
     * @param string $field
     * @param int $len : make value of length
     * @return string
     * @throws \exception
     */
    public function getPlatformUniqueFieldValue($field, $len=16)
    {

        $value = random($len);

        while($this->isExistFieldValue($field, $value))
        {
            $value = random($len);
        }

        return $value;
    }
}