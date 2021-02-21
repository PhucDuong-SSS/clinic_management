<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormRolesRequest extends FormRequest
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
            'role_name' => 'required',
            'display_name' => 'required',
        ];
    }
    public function messages()
    {
        $messages = [
            'role_name.required' => 'Bạn phải điền tên chức vụ',
            'display_name.required' => 'Bạn phải điền tên hiển thị',

        ];

        return $messages;
    }
}
