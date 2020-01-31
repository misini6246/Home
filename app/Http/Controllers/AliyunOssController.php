<?php

namespace App\Http\Controllers;

use OSS\OssClient;

class AliyunOssController extends Controller
{

    private $id = 'LTAIxfky7PJT8bhw';
    private $key = '0gZl2niUsMzPSxLUKNkgCVdZMVvzdX';
    private $endpoint = 'oss-cn-shenzhen.aliyuncs.com';

    private $bucket;

    public function __construct($bucket = 'ossyyg')
    {
        $this->bucket = $bucket;
    }

    public function up_img($object, $path)
    {
        $ossClient = new OssClient($this->id, $this->key, $this->endpoint);
        $response  = $ossClient->uploadFile($this->bucket, $object, $path);
        return $response;
    }

    public function del_img($img)
    {
        $ossClient = new OssClient($this->id, $this->key, $this->endpoint);
        $response  = $ossClient->deleteObject($this->bucket, $img);
        return $response;
    }

    public function get_path($response, $type = 0)
    {
        if ($type == 0) {
            $img_path = str_replace('http://ossyyg.oss-cn-shenzhen.aliyuncs.com/data/feedbackimg/', '', $response['oss-request-url']);
        } else {
            $img_path = 'http://ossyyg.oss-cn-shenzhen.aliyuncs.com/data/feedbackimg/' . $response;
        }
        return $img_path;
    }

    public function get_path_mz($response, $type = 0)
    {
        if ($type == 0) {
            $img_path = str_replace('http://ossyyg.oss-cn-shenzhen.aliyuncs.com/', '', $response['oss-request-url']);
        } else {
            $img_path = 'http://ossyyg.oss-cn-shenzhen.aliyuncs.com/' . $response;
        }
        return $img_path;
    }
}
