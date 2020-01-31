<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/28
 * Time: 14:16
 */

namespace Jai\Contact\Http\Controllers\abc;


interface IQueryType {
/// <summary>查询类型  ：状态查询
    /// </summary>
    const QUERY_TYPE_STATUS = "false";

    /// <summary>查询类型：明细查询
    /// </summary>
    const QUERY_TYPE_DETAIL = "true";
}