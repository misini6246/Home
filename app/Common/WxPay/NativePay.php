<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/10/16
 * Time: 10:21
 */

namespace App\Common\WxPay;


use Illuminate\Support\Facades\Log;

class NativePay
{
    /**
     *
     * 参数数组转换为url参数
     * @param array $urlObj
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v) {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param WxPayUnifiedOrder $input
     */
    public function GetPayUrl($input)
    {
        if ($input->GetTrade_type() == "NATIVE") {
            try {
                $config = new WxPayConfig();
                $result = WxPayApi::unifiedOrder($config, $input);
                return $result;
            } catch (\Exception $e) {
                Log::info(json_encode($e));
            }
        }
        return false;
    }
}