<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormChangePasswordRequest extends FormRequest
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
        return [
            'oldpassword' => 'required',
            'newpassword' => 'required|regex: /(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$)/u',
            'verifyPassword' => 'required|same:newpassword'
        ];
    }

    public function messages()
    {
        $messages = [
            'oldpassword.required' => 'Bạn phải điền mật khẩu cũ!',
            'newpassword.required' => 'Bạn phải điền mật khẩu mới!',
            'newpassword.regex' => 'Mật khẩu phải có tối thiểu 8 ký tự, tối đa 20 ký tự, gồm chữ hoa chữ thường và số',
            'verifyPassword.required' => 'Bạn phải nhập lại mật khẩu mới!',
            'verifyPassword.same' => 'Không trùng khớp mật khẩu mới',
        ];

        return $messages;
    }
}
