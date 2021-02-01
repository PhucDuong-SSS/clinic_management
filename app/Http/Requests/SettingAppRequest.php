<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingAppRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_doctor'   =>  'required|max:200|min:2',
            'degree'        =>  'required|max:200|min:10;',
            'name_clinic'   =>  'required',
            'phone'         =>  'required|numeric|min:10',
            'address'       =>  'required|max:200|min:2'
        ];
    }
    function messages()
    {
        return[
            'name_doctor.required'  =>'Tên bác sĩ không được để trống.',
            'name_doctor.max'       =>'Tối đa 200 kí tự',
            'name_doctor.min'       =>'Tối thiểu 2 kí tự',
            'degree.required'       =>'Học vị không được để trống',
            'degree.max'            =>'Tối đa 200 kí tự',
            'degree.min'            =>'Tối thiểu 10 kí tự',
            'name_clinic.required'  =>'Tên phòng khám không được để trống',
            'phone.required'        =>'Số điện thoại không được để trống',
            'phone.numeric'         =>'Chỉ được nhập số',
            'phone.min'             =>'Tối thiểu 10 số',
            'address.required'      =>'Địa chỉ phòng khám không được để trống',
            'address.max'           =>'Địa chỉ tối đa 200 kí tự',
            'address.min'           =>'Địa chỉ tối thiểu 2 kí tự',
        ];
    }
}
