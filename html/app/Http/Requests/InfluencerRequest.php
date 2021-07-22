<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfluencerRequest extends FormRequest
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
            'name' => 'required',
            'lastname' => 'required',
            'nickname' => 'required',
            'agencia' => 'max:50'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'lastname.required' => 'El apellido es obligatorio',
            'nickname.required' => 'El nickname es obligatorio',
            'agencia.max' => 'La agencia debe tener maximo 50 caracteres'
        ];
    }
}
