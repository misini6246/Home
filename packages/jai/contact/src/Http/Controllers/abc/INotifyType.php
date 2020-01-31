<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 14:03
 */

namespace Jai\Contact\Http\Controllers\abc;


interface INotifyType {
/// <summary>支付结果通知类型：页面通知
    /// </summary>
    const NOTIFY_TYPE_URL = "0";

    /// <summary>支付结果通知类型：服务器通知
    /// </summary>
    const NOTIFY_TYPE_SERVER = "1";
}