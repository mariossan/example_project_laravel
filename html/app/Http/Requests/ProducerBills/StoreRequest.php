<?php

namespace App\Http\Requests\ProducerBills;

use App\Rules\ValidateNumberAndDealer;
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
            'no_factura' => [
                new ValidateNumberAndDealer($this)
            ]
        ];
    }
}
