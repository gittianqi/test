<?php

namespace App\Http\Controllers\Common;

use App\Models\AdminUserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * 登陆
     * @param Request $request
     * @param AdminUserModel $adminUserModel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function login(Request $request,AdminUserModel $adminUserModel)
    {
        if($request->isMethod('post'))
        {
            $username = $request->input('username');
            $password = $request->input('password');
            if(empty($username)) {
                return response()->json(['code' => 2003, 'msg' => "用户名不能为空"]);
            }
            if(empty($password)) {
                return response()->json(['code' => 2004, 'msg' => "密码不能为空"]);
            }

            $admin_user = $adminUserModel->fetchByUsername($username);
            if(!$admin_user) {
                return response()->json(['code' => 2005, 'msg' => "该账户不存在"]);
            }
            if($admin_user['password'] !== $adminUserModel->create_password($password, $admin_user['encrypt'])) {
                return response()->json(['code' => 2006, 'msg' => "密码错误"]);
            }

            session(['adminUser' => $admin_user]);
            return response()->json(['code' => 0, 'msg' => "登录成功"]);
        }else{
            if(session("adminUser"))
            {
                return redirect()->route('index');
            }
            return view('public.login');
        }
    }

    /**
     * 退出登录
     */
    public function outLogin(){
        session(['adminUser' => NULL]);
        return redirect()->route('login');
    }
}
