<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SymptonRequest extends FormRequest
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
            'sympton_name' => 'required|max:200|min:2'
        ];
    }
}
