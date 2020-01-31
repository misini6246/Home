<?php

namespace App\Http\Requests;

class RegisterPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'user_rank' => 'required|exists:user_rank,rank_id',
            'user_name' => 'required|alpha_num|min:2|max:30|unique:users',
            'password' => 'required|alpha_dash|min:6|max:24|confirmed',
            'ls_name' => 'alpha|min:2|max:10',
            'msn' => 'required|min:5|max:50|unique:users',
            'province' => 'required|exists:region,region_id,region_type,1',
            'city' => 'required|exists:region,region_id,region_type,2',
            'district' => 'required|exists:region,region_id,region_type,3',
        ];
        if (isset($rules[$this->request->get('verify_key')])) {
            return [
                $this->request->get('verify_key') => $rules[$this->request->get('verify_key')]
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'user_rank.required' => '请选择用户类型',
            'user_name.required' => '请输入2-30位字母、数字或中文组成的用户名',
            'user_name.alpha_num' => '请输入2-30位字母、数字或中文组成的用户名',
            'user_name.min' => '请输入2-30位字母、数字或中文组成的用户名',
            'user_name.max' => '请输入2-30位字母、数字或中文组成的用户名',
            'user_name.unique' => '用户名已存在',
            'password.required' => '请输入6-24位字母或数字组成的密码',
            'password.alpha_num' => '请输入6-24位字母或数字组成的密码',
            'password.min' => '请输入6-24位字母或数字组成的密码',
            'password.max' => '请输入6-24位字母或数字组成的密码',
            'password.confirmed' => '两次密码输入不一致',
            'ls_name.alpha' => '请输入正确的真实姓名',
            'ls_name.min' => '请输入正确的真是姓名',
            'ls_name.max' => '请输入正确的真是姓名',
            'msn.required' => '请与营业执照上名称一致，以便尽快通过审核',
            'msn.min' => '请与营业执照上名称一致，以便尽快通过审核',
            'msn.max' => '请与营业执照上名称一致，以便尽快通过审核',
            'msn.unique' => '企业名称已存在',
            'province.required' => '请选择完整的所在地区',
            'province.exists' => '选择的区域有误',
            'city.required' => '请选择完整的所在地区',
            'city.exists' => '选择的区域有误',
            'district.required' => '请选择完整的所在地区',
            'district.exists' => '选择的区域有误',
        ];
    }
}
