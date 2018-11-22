<?php

namespace App\Http\Controllers\Platform;

//use App\Services\OSS;
use App\Oss;
use App\Models\PlatformModel;
use App\Service\PlatformService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PlatformController extends Controller
{
    protected  $model_name = '合作平台管理';

    /**
     * 会员列表
     * @param Request $request
     * @param PlatformService $platformservice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, PlatformService $platformservice){
        $this->SEO('平台列表');
        $data = $platformservice->getList();

        return $this->display("platform.index",['data'=>$data]);
    }

    /**
     * 编辑会员
     * @param Request $request
     * @param PlatformService $platformservice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request, PlatformService $platformservice){

        $this->SEO('平台会员编辑');

        if($request->isMethod('post')){
            try {
                $data = $request->only('id', 'islock', 'at_num', 'at_type', 'login_url', 'exchange_url');

                $platformservice->update($data);

                $code = 0;
                $message = "操作成功";
            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }
            return response()->json(['code' => $code, 'msg' => $message]);
        }

        $id = $request->input('id');
        $user = $platformservice->getPlatformInfo($id);

        return $this->display("platform.edit",['user'=>$user]);
    }

    /**
     * 添加平台会员
     * @param Request $request
     * @param PlatformService $platformservice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function add(Request $request, PlatformService $platformservice){

        $this->SEO('平台会员添加');

        if($request->isMethod('post')){
            try {
                $data = $request->only( 'username','password', 'mobile', 'at', 'islock' , 'login_url', 'exchange_url');

                $platformservice->add($data);
                $code = 0;
                $message = "操作成功";
            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }
            return response()->json(['code' => $code, 'msg' => $message]);
        }


        $userplatform = new PlatformModel();

        return $this->display("platform.add",['user'=>$userplatform]);
    }

    /**
     * 删除平台会员
     * @param Request $request
     * @param PlatformService $platformservice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function del(Request $request, PlatformService $platformservice){

        $this->SEO('平台会员删除');

        if($request->isMethod('post')){
            try {
                $id = $request->input('id');
                $platformservice->del($id);
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
     * 上传平台LOGO
     * @param Request $request
     * @param PlatformService $platformservice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function uploadLogo(Request $request){

        if ($request->isMethod('POST')) {

            try {

                if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

                    //获取文件的扩展名
                    $file = $request->file('photo');//获取图片
                    $allowed_extensions = ["png", "jpg", "gif"];
                    $ext = $file->getClientOriginalExtension();
                    if ($ext && !in_array($ext, $allowed_extensions)) {
                        return response()->json([
                            'code' => 53016,
                            'msg' => '只能上传 png | jpg | gif格式的图片'
                        ]);
                    }

                    //本地存储
//                    $path = $file->getRealPath();
//                    $filename = date('Y-m-d-h-i-s').'.'.$ext;
//                    $ret = Storage::disk('logo')->put($filename, file_get_contents($path));
//                    if (!$ret) throw  new \Exception('文件上传失败',53016);
//                    $url = '/imgsys/app/public/logo/'.$filename;


                    //oss 存储
                    $OSS = new Oss(true);
                    $img = $_FILES;
                    $path = 'images/logo/'.date("Y-m-d").'/';
                    $url = $OSS->publicUpload($img['photo'],$path,$ext);


                    //更新平台LOGO
                    $platformid = $request->id;
                    $ret = PlatformModel::where('id',$platformid)->update(['logo'=>$url]);
                    if (!$ret) throw  new \Exception('更新失败',53009);


                    $code = 0;
                    $message = $url;
                }

            } catch (\Exception $e) {
                $code = $e->getCode();
                $message = $e->getMessage();
            }


            return response()->json(['code' => $code, 'msg' => $message]);
        }
    }


}
