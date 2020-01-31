<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 14:04
 */

namespace Jai\Contact\Http\Controllers\abc;


interface IIsBreakAccountType {
/// <summary>
    /// 交易是否分账：分账
    /// </summary>
    const IsBreak_TYPE_YES = "1";

    /// <summary>
    /// 交易是否分账：  不分账
    /// </summary>
    const IsBreak_TYPE_NO = "0";
}