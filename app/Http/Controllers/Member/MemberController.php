<?php

namespace App\Http\Controllers\Member;

use App\Models\MemberModel;
use App\Service\MemberService;
use App\Service\MemberLogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    protected  $model_name = '会员管理';

    /**
     * 会员列表
     * @param Request $request
     * @param MemberService $memberService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, MemberService $memberService){
        $this->SEO('会员列表');
        $where = array();

        if($request->isMethod('post')){

            $data = $request->only('findk', 'findv');
            if (!empty($data['findv'])) $where[$data['findk']] =  $data['findv'];
        }


        $data = $memberService->getList($where);
        return $this->display("member.index",['data'=>$data]);
    }

    /**
     * 编辑会员
     * @param Request $request
     * @param MemberService $memberService
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, MemberService $memberService){
        $this->SEO('会员编辑');
        if($request->isMethod('post')){
            try {
                $data = $request->only('id', 'islock', 'at_num', 'at_type', 'money_num', 'money_type');

                $memberService->update($data);

                $code = 0;
                $message = "操作成功";
            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }
            return response()->json(['code' => $code, 'msg' => $message]);
        }

        $id = $request->input('id');
        $user = MemberModel::find($id);
        return $this->display("member.edit",['user'=>$user]);
    }
}
