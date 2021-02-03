<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'full_name'           =>  'required|max:50|min:4',
            'dob'                 =>  'required',
            'gender'              =>  'required',
            'guardian_name'       =>  'required|max:50|min:4',
            'phone_number'        =>  'required',
            'address'           =>  'required',
            'prognosis'           =>  'required',
            'exam_price'           =>  'required',
            'exam_date'           =>  'required',






        ];
    }

    function messages()
    {
        return[
            'full_name.required'    =>'Tên bệnh nhân không được để trống.',
            'full_name.max'          =>'Tối đa 200 kí tự',
            'full_name.min'          =>'Tối thiểu 4 kí tự',
            'dob.required'           => 'Ngày sinh không được để trống',
            'gender.required'        => 'Giới tính không được để trống',
            'guardian_name.required'        => 'Tên người giám hộ không được để trống',
            'guardian_name.min'        => 'Tối thiểu 4 ký tự',
            'guardian_name.max'        => 'Tối đa 50 ký tự',
            'phone_number.required'        => 'Số điện thoại không được để trống',
            'address.required'        => 'Địa chỉ không được để trống',
            'prognosis.required'        => 'Chuẩn đoán không được để trống',
            'exam_price.required'        => 'Tiền không được để trống',
            'exam_date.required'        => 'Ngày khám không được để trống',

        ];
    }
}
