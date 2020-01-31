<?php

namespace App\Http\Controllers\Other;

use App\Http\Controllers\Controller;
use App\Models\YzyC;
use App\Models\YzyInfo;
use Illuminate\Http\Request;

class YzyController extends Controller
{
    public function add_info(Request $request)
    {
        $consignee = trim($request->input('consignee', ''));
        $phone = trim($request->input('phone', ''));
        $address = trim($request->input('address', ''));
        $name = trim($request->input('name', ''));
        $content = trim($request->input('content', ''));
        $flag = intval($request->input('flag'));
        if (empty($consignee)) {
            ajax_return('联系人不能为空', 1);
        }
        if (empty($phone)) {
            ajax_return('联系电话不能为空', 1);
        }
        $rule = '/^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/';
        if (!preg_match($rule, $phone)) {
            ajax_return('请输入正确的联系电话', 1);
        }
        if (empty($address)) {
            ajax_return('详细地址不能为空', 1);
        }
        if ($flag == 0) {
            if (empty($name)) {
                ajax_return('诊所名称不能为空', 1);
            }
            if (empty($content)) {
                ajax_return('咨询内容不能为空', 1);
            }
        }
        $info = YzyInfo::where('phone', $phone)->orwhere('name', $name)->where('flag', $flag)->first();
        if ($info) {
            ajax_return('您已经提交过申请', 1);
        }
        $info = new YzyInfo();
        $info->consignee = $consignee;
        $info->phone = $phone;
        $info->address = $address;
        $info->name = $name;
        $info->content = $content;
        $info->flag = $flag;
        if (auth()->check()) {
            $info->user_id = auth()->user()->user_id;
        }
        $info->save();
        if ($info->id == 0) {
            ajax_return('提交申请失败', 1);
        }
        ajax_return('提交申请成功');
    }

    public function add_c()
    {
        $user = auth()->user();
        $info = YzyC::find($user->user_id);
        if (!$info) {
            ajax_return('您不满足领取条件', 1);
        }
        if ($info->type == 1) {
            ajax_return('您已领取过', -1);
        }
        $info->type = 1;
        $info->save();
        ajax_return('领取成功');
    }
}
