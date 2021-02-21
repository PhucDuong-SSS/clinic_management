<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
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
            'unit_name' => 'required|max:200|min:2|unique:units'
        ];
    }
    function messages()
    {
        return [
            'unit_name.required'  => 'Tên đơn vị không được để trống.',
            'unit_name.max'       => 'Tối đa 200 kí tự',
            'unit_name.min'       => 'Tối thiểu 2 kí tự',
            'unit_name.unique'    => 'Đơn vị đã tồn tại',
        ];
    }
}
