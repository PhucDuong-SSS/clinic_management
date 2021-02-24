<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedEditRequest extends FormRequest
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
            'medicine_name' => 'required|unique:medicines,medicine_name,' . $this->id,
            'medicine_amount' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'unit' => 'required',
        ];
    }
    public function messages()
    {
        $messages = [
            'category.required' => 'Bạn phải chọn loại thuốc',
            'medicine_name.required' => 'Bạn phải điền tên thuốc',
            'medicine_name.unique' => 'Tên thuốc này đã được có',
            'medicine_amount.required' => 'Bạn phải điền số lượng',
            'medicine_amount.numeric' => 'Số lượng là dạng số',
            'sell_price.required' => 'Bạn phải điền giá bán',
            'sell_price.numeric' => 'Giá bán phải là dạng số',
            'unit.unique' => 'Bạn phải chọn đơn vị',
        ];

        return $messages;
    }
}
