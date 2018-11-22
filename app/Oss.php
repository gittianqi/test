<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OSS\OssClient;

class Oss extends Model
{

    private $AccessKeyId = 'LTAIVMG8OfOJu4S0';
    private $AccessKeySecret = 'BMv1dhw0CDV1RWBHtvI6M19vf7UWxF';
    private $isBindUrl = true;
    private $BindUrl = 'img.huanyuanlian.com';
    private $ossClient;
    private $isInner;
    private $endpoint;




    public function __construct($isInternal = false)
    {

        $this->isInner = $isInternal;
        $this->endpoint = $this->isInner ? 'oss-cn-hangzhou-internal.aliyuncs.com' : 'oss-cn-hangzhou.aliyuncs.com';
        $this->ossClient = new OssClient($this->AccessKeyId,$this->AccessKeySecret,$this->endpoint, false);
    }

    public function publicUpload($file,$path,$ext)
    {
        $filename = md5_file($file['tmp_name']) . substr($file['name'], strpos($file['name'], '.'));
        $img_path =  $path . $filename;
        $ossFileName = $img_path;

        $res = $this->ossClient->uploadFile(
            'rschain',
            $ossFileName,
            $file['tmp_name'],
            []
        );

        if ($this->isBindUrl){
            $url =  'https://'.$this->BindUrl.'/'.$ossFileName;
        }else {
            $url =  'https://rschain'.$this->endpoint.'/'.$ossFileName;
        }


        return $url;
    }

    public function uEditorUpload($tmpName,$fileName,$path)
    {
        $filename = md5_file($tmpName) . substr($fileName, strpos($fileName, '.'));
        $img_path     =  $path . $filename;
        $ossFileName = $img_path;
        $res = $this->ossClient->uploadFile(
            'zgb',
            $ossFileName,
            $tmpName,
            []
        );
    }

    /**
     *   上传图片到OSS
     */
    public function uploadFile($file,$type = ""){
        $accessKeyId = "LTAIVMG8OfOJu4S0";
        $accessKeySecret = "BMv1dhw0CDV1RWBHtvI6M19vf7UWxF";
        $endpoint = 'http://rschain.oss-cn-hangzhou-internal.aliyuncs.com';
        $bucket = "rschain";
        $object = 'oAZUF0T4qmQoIGo8-yB6-VJgI0-E'.time().rand(1,9999).'.jpg';
        $filePath = $file;
        $download_file = "images/avatar/". time().rand(1111,9999).'.jpg';
        try {
            if($type != 2){
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $url = $ossClient->uploadFile($bucket, $object, $filePath);
            }else{
                // var_dump($filePath);die;
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
                $url = $ossClient->putObject($bucket, $object, $filePath);
            }

            // 图片缩放
            $options = array(
                OssClient::OSS_FILE_DOWNLOAD => $download_file,
                OssClient::OSS_PROCESS => "image/resize,m_mfit,h_500,w_500"
            );
            $ossClient->getObject($bucket, $object, $options);

            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $url = $ossClient->uploadFile($bucket, $object, $download_file);

            //删除临时文件
            unlink($download_file );

            return $url;
        } catch(OssException $e) {
            print $e->getMessage();
            echo json_encode(array('code'=>1));
            return false;
        }
    }

}
