<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionMedicineRequest extends FormRequest
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
            'morning' => 'integer|required_with:note_morning|nullable',
            'midday' => 'integer|required_with:note_midday|nullable',
            'afternoon' => 'integer|required_with:note_afternoon|nullable',
            'evening' => 'integer|required_with:note_evening|nullable',
            'note_morning' => 'required_with:morning|string|nullable',
            'note_midday' => 'required_with:midday|string|nullable',
            'note_afternoon' => 'required_with:afternoon|string|nullable',
            'note_evening' => 'required_with:evening|string|nullable',
            'number_of_day' => 'required|integer|between:1,99',
            'sell_price' => 'required|integer',

        ];
    }

    function messages()
    {
        return [
            'morning.integer' => 'Lượng thuốc buổi sáng cần nhập số nguyên',
            'note_morning.required_with' =>'Cần nhập thêm ghi chú cho buổi sáng',
            'note_midday.required_with' =>'Cần nhập thêm ghi chú cho buổi trưa',
            'note_afternoon.required_with' =>'Cần nhập thêm ghi chú cho buổi chiều',
            'note_evening.required_with' =>'Cần nhập thêm ghi chú cho buổi tối',
            'morning.required_with' => 'Cần nhập thêm lượng thuốc cho buổi sáng',
            'midday.integer' => 'Lượng thuốc buổi trưa cần nhập số nguyên',
            'midday.required_with' => 'Cần nhập thêm lượng thuốc cho buổi trưa',
            'afternoon.integer' => 'Lượng thuốc buổi chiều cần nhập số nguyên',
            'afternoon.required_with' => 'Cần nhập thêm lượng thuốc cho buổi chiều',
            'evening.integer' => 'Lượng thuốc buổi tối cần nhập số nguyên',
            'evening.required_with' => 'Cần nhập thêm lượng thuốc cho buổi tối',
            'number_of_day.required' => 'Cần nhập số ngày uống thuốc',
            'number_of_day.integer' => 'Cần nhập số ngày uống thuốc là số nguyên',
            'number_of_day.between' => 'Cần nhập số ngày uống thuốc từ 1 đến 99 ngày',
            'sell_price.required' => 'Cần nhập giá bán thuốc',
            'sell_price.integer' => 'Cần nhập giá bán thuốc là số nguyên',

        ];

    }
}
