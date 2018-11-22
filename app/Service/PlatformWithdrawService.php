<?php

namespace App\Service;

use App\Models\OrderModel;
use App\Models\PlatformModel;
use App\Models\PlatformWithdrawModel;
use Illuminate\Support\Facades\DB;

class PlatformWithdrawService
{


    /**
     * 获取指定状态提现申请列表
     * @param  int $Status ：状态（0待处理 1通过 2拒绝 3所有）
     * @return bool
     */
    public function  lists($Status)
    {

        $where = array();
        if ($Status != 3 ){
            $where['d.status'] = $Status;
        }

        $col = array();
        $col[]= 'd.*';
        $col[]= 'p.username as platform_username';


        $data = DB::table('platform_withdraw as d')
            ->select($col)
            ->where($where)
            ->leftJoin('platform as p', function($join){
                $join->on('p.id','=','d.pid');
            })->orderBy('d.id','desc')->get();

        if(!$data)
        {
            $this->msg = '数据为空';
            return false;
        }


        foreach ($data as $k => $v)
        {
            $v->method_name = getWithdrawMethodName($v->method);
            $v->status_name = $this->getWithdrawStatusName($v->status);
        }

        return $data;
    }


    /**
     * 获取提现状态名称
     * @param  object $order
     * @return string
     */
    public function  getWithdrawStatusName($status)
    {

        $statusname = '';

        $list = array(
            0 => '待处理',
            1 => '通过',
            2 => '拒绝',
            3 => '未知',
        );


        return $list[$status];


    }

    /**
     * 添加提现申请
     * @param  object $order
     * @return string
     */
    public function  checkWithdraw($id, $status)
    {

        //校验信息
        if (!in_array($status,[1,2]))
            throw new \Exception('数据异常',51001);

        //获取基本信息
        $admin = session('adminUser');
        $withdraw = PlatformWithdrawModel::where('id', $id)->first();
        $platform_slaver = PlatformModel::where('id', $withdraw->pid)->first();
        if (!empty($platform_slaver['platform_id'])){
            $platform_master = PlatformModel::where('id', $platform_slaver->platform_id)->first();

        }else {
            $platform_master = $platform_slaver;
        }
        $platformid = $platform_master['id'];



        //数据提交
        try{

            DB::beginTransaction();

            //更新申请提现状态
            $ret = $withdraw->update(['status'=>$status, 'operator'=>$admin['id'], 'operator_name'=>$admin['username']]);


            if ($status == 1){//通过审核


                if ($platform_master->frozen_at - $withdraw->total_num < 0 )
                    throw new \Exception('平台AT数量不足',540002);

                //金额变动，写商户平台日志
                $platlogid = DB::table('platform_log')->insertGetId([
                    'pid'=>$platformid,
                    'value'=> floatval($withdraw->total_num),//变动金额
                    'msg'=>'商户提现申请',
                    'time'=>time(),
                    'type'=>'apply_withdraw',
                    'admin_id'=>$admin['id'],
                    'detail'=>'{"old_at":'.strval($platform_master->at+$platform_master->frozen_at).
                        ',"change_at":'.strval($withdraw->total_num).',"new_at":'.
                        strval(floatval($platform_master->at+$platform_master->frozen_at- $withdraw->total_num)).'}',
                ]);


                //扣除商户平台AT
                $platform_master->frozen_at -= $withdraw->total_num;
                $platform_master->save();

            }else if ($status == 2){//审核拒绝


                //还原商户平台冻结AT
                $platform_master->frozen_at -= $withdraw->total_num;
                $platform_master->at += $withdraw->total_num;
                $platform_master->save();
            }


            DB::commit();
            return true;

        }catch(\Exception $e){

            DB::rollback();
            throw new \Exception("审核提现异常",54001);
            return false;

        }

    }

}