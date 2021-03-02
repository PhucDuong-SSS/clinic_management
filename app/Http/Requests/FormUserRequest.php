<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormUserRequest extends FormRequest
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
            'full_name' => 'required|min:2|max:30',
            'user_name' => 'required|regex: /(^[a-z0-9]{8,30}$)/u|unique:users',
            'email' => 'required|min:8|unique:users',
            'phone' => 'required|numeric|unique:users',
            'address' => 'required|min:2',
            'image' => 'required|image',
            'password' => 'required|regex: /(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$)/u',
        ];
    }

    public function messages()
    {
        $messages = [
            'full_name.required' => 'Bạn phải điền họ tên',
            'full_name.min' => 'Tên phải có ít nhất 2 ký tự',
            'full_name.max' => 'Tên phải có ít hơn 30 ký tự',
            'user_name.required' => 'Bạn phải điền tên đăng nhập',
            'user_name.regex' => 'Tên đăng nhập có tối thiểu 8 ký tự, không có kí tự đặc biệt, tối đa 30 ký tự',
            'user_name.unique' => 'Tên đăng nhập này đã được dùng',
            'email.required' => 'Bạn phải điền email',
            'email.min' => 'Email phải có ít nhất 8 ký tự',
            'email.unique' => 'Email đã có người dùng',
            'email.email' => 'Sai định dạng email',
            'phone.required' => 'Bạn phải điền số điện thoại',
            'phone.numeric' => 'Số điện thoại phải là dạng số',
            'phone.unique' => 'Số điện thoại đã có người dùng',
            'address.required' => 'Bạn phải điền địa chỉ',
            'address.min' => 'Địa chỉ phải có ít nhất 2 ký tự',
            'image.required' => 'Bạn phải thêm ảnh đại diện',
            'image.image' => 'File ảnh không đúng',
            'password.required' => 'Bạn phải điền mật khẩu!',
            'password.regex' => 'Mật khẩu phải có tối thiểu 8 ký tự, tối đa 20 ký tự, gồm chữ hoa chữ thường và số',
        ];

        return $messages;
    }
}
