<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'image' => 'max:2048|mimes:jpeg,png,jpg',
            'user_id' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'image.max' => "La imagen no puede tener más de 2048 kilobytes de peso."
        ];
    }
}
