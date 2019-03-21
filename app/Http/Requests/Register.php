<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
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
     *定义规则
     * @return array
     */
    public function rules()
    {
        return [
           'admin_tel'=>'required|regex:/^[0-9]{11}$/',
            'admin_pwd'=>'required|regex:/^[a-z0-9]{6,16}$/'
        ];
    }
    /*
     * 定义错误信息
     */
    public function messages()
    {
        return [
            'admin_tel.required'=>'手机号不能为空',
            'admin_tel.regex'=>'手机号必须是十一位数字',
            'admin_pwd.required'=>'密码不能为空',
            'admin_pwd.regex'=>'密码由数字、字母 六到十六位组成'
        ];
    }
}
