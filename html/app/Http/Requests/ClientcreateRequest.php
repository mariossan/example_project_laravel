<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientcreateRequest extends FormRequest
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
            'client_code'   => 'required',
            'business_name' => 'required',
            'fiscal_name'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'client_code.required'   => 'El código de cliente es obligatorio',
            'business_name.required' => 'La razón social es obligatoria',
            'fiscal_name.required'   => 'EL nombre fiscas es obligatorio',
        ];
    }
}
