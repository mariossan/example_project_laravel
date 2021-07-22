<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerRequest extends FormRequest
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
            'dealer_code'       => 'required',
            'business_name'     => 'required',
            'CifDni'            => 'required',
            'contable_code'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'dealer_code.required'       => 'El código de distribuidor es obligatorio',
            'business_name.required'     => 'La razón social es obligatoria',
            'CifDni.required'            => 'La CifDni es obligatoria',
            'contable_code.required'     => 'El código contable es obligatorio'
        ];
    }
}
