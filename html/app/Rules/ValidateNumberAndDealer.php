<?php

namespace App\Rules;

use App\Models\CampaignBillMonth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ValidateNumberAndDealer implements Rule
{
    public $number;
    public $dealer_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->number = $request->input('no_factura');
        $this->dealer_id = $request->input('dealer_id');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !CampaignBillMonth::query()
            ->where('no_factura','=',$this->number)
            ->where('dealer_id','=',$this->dealer_id)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ya existe una factura con el mismo número de factura y mismo proveedor';
    }
}
