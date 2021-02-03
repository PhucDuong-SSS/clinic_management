<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormEditUserRequest extends FormRequest
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
            'user_name' => 'required|regex: /(^[a-z0-9]{8,30}$)/u|unique:users,user_name,' . $this->id,
            'email' => 'required|min:2|unique:users,email,' . $this->id,
            'phone' => 'required|numeric|unique:users,phone,' . $this->id,
            'address' => 'required|min:2',
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
            'phone.min' => 'Số điện thoại phải là dạng số',
            'phone.unique' => 'Số điện thoại đã có người dùng',
            'address.required' => 'Bạn phải điền địa chỉ',
            'address.min' => 'Địa chỉ phải có ít nhất 2 ký tự',
        ];

        return $messages;
    }
}
