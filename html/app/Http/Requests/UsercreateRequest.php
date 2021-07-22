<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsercreateRequest extends FormRequest
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
            "name"      => "required",
            "email"     => "required|unique:users",
            "password"  => "nullable",
            "role_id"   => "required"
        ];
    }

    public function messages()
    {
        return [
            "name.required"      => "El nombre es obligatorio",
            "email.required"     => "El email es obligatorio",
            "email.unique"       => "EL correo ya ha sido asignado previamente",
            "password.required"  => "La contraseña es obligatoria",
            "role_id.required"   => "El rol de usuario es obligatorio"
        ];
    }
}
