<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotsRequest extends FormRequest
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
            'code' => 'required|unique:lots',
            'medicine' => 'required',
            'medicine_amount' => 'required|numeric',
            'expired_date' => 'required',
            'receipt_date' => 'required',
            'total_price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        $messages = [
            'code.required' => 'Bạn phải điền mã đơn hàng',
            'code.unique' => 'Mã đơn hàng này đã được có',
            'medicine.required' => 'Bạn phải chọn loại thuốc',
            'medicine_amount.required' => 'Bạn phải điền số lượng',
            'medicine_amount.numeric' => 'Số lượng phải là dạng số',
            'expired_date.required' => 'Bạn phải điền ngày sản xuất',
            'receipt_date.required' => 'Bạn phải điền ngày hết hạn',
            'total_price.required' => 'Bạn phải điền tổng giá',
            'total_price.numeric' => 'Tổng giá phải là dạng số',
        ];

        return $messages;
    }
}
