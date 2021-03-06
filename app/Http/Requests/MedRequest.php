<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedRequest extends FormRequest
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
            'category' => 'required',
            'medicine_name' => 'required|unique:medicines',
            'sell_price' => 'required|numeric',
            'unit' => 'required',
            'image' => 'required|image',
        ];
    }
    public function messages()
    {
        $messages = [
            'category.required' => 'Bạn phải chọn loại thuốc',
            'medicine_name.required' => 'Bạn phải điền tên thuốc',
            'medicine_name.unique' => 'Tên thuốc này đã được có',
            'sell_price.required' => 'Bạn phải điền giá bán',
            'sell_price.numeric' => 'Giá bán phải là dạng số',
            'unit.required' => 'Bạn phải chọn đơn vị',
            'image.required' => 'Bạn phải thêm ảnh đại diện',
            'image.image' => 'File ảnh không đúng',
        ];

        return $messages;
    }
}
