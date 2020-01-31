<?php

namespace App\Http\Controllers;

class SmsController extends Controller
{
    protected $account = 'N2680582';
    protected $password = 'pi6d0jRgt';
    protected $url = 'http://smssh1.253.com/msg/send/json';

    public function sendSms($mobile, $msg, $needstatus = 'true')
    {
        $postArr = array(
            'account' => $this->account,
            'password' => $this->password,
            'msg' => urlencode($msg),
            'phone' => $mobile,
            'report' => $needstatus
        );
        $result = $this->curlPost($this->url, $postArr);
        return $result;
    }

    public function sendVariableSms($msg, $params)
    {
        $postArr = array(
            'account' => $this->account,
            'password' => $this->password,
            'msg' => $msg,
            'params' => $params,
            'report' => 'true'
        );

        $result = $this->curlPost($this->url, $postArr);
        return $result;
    }

    private function curlPost($url, $postFields)
    {
        $postFields = json_encode($postFields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
            )
        );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec($ch);
        if (false == $ret) {
            $result = curl_error($ch);
        } else {
            $rsp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 " . $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close($ch);
        return $result;
    }
}
