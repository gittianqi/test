<?php

namespace App\Service;

use App\Models\MemberModel;
use Illuminate\Support\Facades\DB;

class MemberService
{
    /**
     * 获取会员列表
     * @param array $arr
     * @return bool
     */
    public function getList($arr = [])
    {
//        $data     = MemberModel::where($arr)->orderBy('id','desc')->get();
        $data     = MemberModel::where($arr)->orderBy('id','desc')->paginate(25);
        if(!$data)
        {
            $this->msg = '数据为空';
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
        $MemberModel = new MemberModel();
        if((int)$data['id'] < 1)
            throw new \exception('数据异常', 51001);
        if(isset($data['at_type']) && !in_array($data['at_type'], ['-','+']))
            throw new \exception('数据异常', 51001);
        if(isset($data['money_type']) && !in_array($data['money_type'], ['-','+']))
            throw new \exception('数据异常', 51001);
        if(isset($data['islock']) && !in_array($data['islock'], [0,1]))
            throw new \exception('数据异常', 51001);


        $member = $MemberModel::find($data['id']);
        if(!$member)
            throw new \exception('该账户不存在', 52005);

        $map = [];
        if(isset($data['islock']))
            $map['islock'] = $data['islock'];

        if(isset($data['money_num']) && (int)$data['money_num'] <= 0)
            throw new \exception('请正确填写调整的余额', 52001);
        if(isset($data['money_num']) && (int)$data['money_num'] > 0){
            $money = ($data['money_type'] == '+') ? $member->money + $data['money_num'] : $member->money - $data['money_num'];
            $map['money'] = max(0, $money);
        }
        if(isset($data['at_num']) && (int)$data['at_num'] <= 0)
            throw new \exception('请正确填写调整的AT', 52002);
        if(isset($data['at_num']) &&(int)$data['at_num'] > 0){
            $at = ($data['at_type'] == '+') ? $member->at + $data['at_num'] : $member->at - $data['at_num'];
            $map['at'] = max(0, $at);
        }

        //开启事务
        DB::beginTransaction();
        try{
            $MemberModel->where('id', $data['id'])->update($map);


            $data['msg'] = (isset($data['msg']) && trim($data['msg'])) ? $data['msg'] : '';

            // 资金变动日志
            $MemberLogService = new MemberLogService();
            if(in_array('money', array_keys($map))){
                $detail = [
                    'old_money' => $member->money,
                    'change_money' => $map['money'] - $member->money,
                    'new_money' => $map['money'],
                ];

                $MemberLogService->add($data['id'], $map['money'] - $member->money, $data['msg'],'money', $detail, operator()['id']);

            }
            if(in_array('at', array_keys($map))){
                $detail = [
                    'old_at' => $member->at,
                    'change_at' => $map['at'] - $member->at,
                    'new_at' => $map['at'],
                ];
                $MemberLogService->add($data['id'], $map['at'] - $member->at, $data['msg'],'at', $detail, operator()['id']);
            }

            DB::commit();
            return true;
        }catch(\Exception $e){
            DB::rollback();
            throw new \exception("更新失败",51002);
        }
    }

}