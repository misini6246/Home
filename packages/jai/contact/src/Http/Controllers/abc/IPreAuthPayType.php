<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 14:16
 */

namespace Jai\Contact\Http\Controllers\abc;


interface IPreAuthPayType {
/// <summary>
    /// 预授权取消(Cancel)
    /// </summary>
    const PREAUTHPAY_TYPE_CANCEL = "Cancel";
    /// <summary>
    /// 预授权确认(Confirm)
    /// </summary>
    const PREAUTHPAY_TYPE_CONFIRM = "Confirm";
}