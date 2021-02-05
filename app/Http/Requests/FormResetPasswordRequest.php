<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormResetPasswordRequest extends FormRequest
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
            'password' => 'required|regex: /(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$)/u',
            'password_confirmation' => 'required|same:password'
        ];
    }
    public function messages()
    {
        $messages = [
            'password.required' => 'Bạn phải điền mật khẩu mới!',
            'password.regex' => 'Mật khẩu phải có tối thiểu 8 ký tự, tối đa 20 ký tự, gồm chữ hoa chữ thường và số',
            'password_confirmation.required' => 'Bạn phải nhập lại mật khẩu mới!',
            'password_confirmation.same' => 'Không trùng khớp mật khẩu mới',
        ];

        return $messages;
    }
}
