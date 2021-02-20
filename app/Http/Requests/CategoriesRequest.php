<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'med_category_name' => 'required|max:200|min:2|unique:med_categories,med_category_name,' . $this->id,
            'description' => 'required'

        ];
    }
    function messages()
    {
        return [
            'med_category_name.required'  => 'Tên loại thuốc không được để trống.',
            'med_category_name.max'       => 'Tối đa 200 kí tự',
            'med_category_name.min'       => 'Tối thiểu 2 kí tự',
            'med_category_name.unique'    => 'Loại thuốc đã tồn tại',
            'description.required'  => 'Mô tả không được để trống.',
        ];
    }
}
