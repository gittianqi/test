<?php

namespace App\Http\Controllers\Withdraw;

use App\Service\OrderService;
use App\Service\PlatformWithdrawService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    protected  $model_name = '审核';


    public function index(Request $request, $status)
    {
        $this->SEO('提现审核');
        $service = new PlatformWithdrawService();
        $data = $service->lists($status);


        return $this->display("withdraw.index", ['data'=>$data]);
    }

    /**
     * 通过审核商户提现申请
     * */
    public function agreeWithdraw(Request $request)
    {
        $this->SEO('申请提现');

        if($request->isMethod('post')){
            try {

                $id = $request->input('id');
                $service = new PlatformWithdrawService();
                $service->checkWithdraw($id, 1);

                $code = 0;
                $message = "操作成功";
            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }
            return response()->json(['code' => $code, 'msg' => $message]);
        }
    }

    /**
     * 拒绝商户提现申请
     * */
    public function refuseWithdraw(Request $request)
    {
        $this->SEO('申请提现');

        if($request->isMethod('post')){
            try {

                $id = $request->input('id');
                $service = new PlatformWithdrawService();
                $service->checkWithdraw($id, 2);
                $code = 0;
                $message = "操作成功";
            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }
            return response()->json(['code' => $code, 'msg' => $message]);
        }

    }
}
