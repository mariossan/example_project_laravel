<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampaignRequest extends FormRequest
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
            "client_id"             => "required",
            "agencia"               => "required",
            "advertiser_id"         => "required",
            "name"                  => "required",
            "month_start"           => "required",
            "month_end"             => "required",
            "total_months"          => "required",
            //"extraprima_agencia"    => "required",
            "user_id"               => "required",
            "ingresos"              => "required",
            "ppto_gastos"           => "required",
            "margen"                => "required",
            "mes"                   => "required",
            "ingresosMes"           => "required",
            "presupuestosMes"       => "required",
        ];
    }

    public function messages()
    {
        return [
            "client_id.required"             => "El CLiente es obligatorio",
            "agencia.required"               => "La agencia es obligatoria",
            "advertiser_id.required"         => "El anunciantes es obligatorio",
            "name.required"                  => "El nombre de la campaña es obligatoria",
            "month_start.required"           => "El mes de inicio es obligatorio",
            "month_end.required"             => "Es mes de fin es obligatorio",
            "total_months.required"          => "EL total de  meses son obligatirios",
            //"extraprima_agencia.required"    => "La extraprima es obligatoria",
            "user_id.required"               => "Los producers son obligatorios",
            "ingresos.required"              => "Los ingresos son obligatorios",
            "ppto_gastos.required"           => "El presupuesto de gastos es obligatorio",
            "margen.required"                => "El margen es obligatorio",
            "mes.required"                   => "El nombre de cada mes es obligatorio",
            "ingresosMes.required"           => "El ingreso de cada mes es obligatorio",
            "presupuestosMes.required"       => "El ingreso presupuesto para cada mes es obligatorio",
        ];
    }
}
