<?php

namespace App\Http\Traits;

use App\Models\CampaignMonth;

/**
* Trait destinado para manejo de archivos en todo el sistema
*/
trait MotorTrait
{
    /**
    * @method
    * @param
    * @return
    */
    public function calculateMotor( $campaign )
    {
        $final_response     = array();
        $aux_prov_acum      = 0;
        $total_elements     = count( $campaign->months ) - 1;
        $suma_ingreso_real  = 0;
        $suma_gasto_real    = 0;

        //dd( $total_elements );

        /* hacemos la lectura de  datos para calcular el motor mes tras mes*/
        foreach ($campaign->months as $key => $month) {

            /*
             *    Cálculo gasto real
             */
            $gasto_real = 0;

            foreach ($month->gastos as $key2 => $gastoItem) {
                $gasto_real += $gastoItem->gasto;
            }

            if ( $key == $total_elements ) {
                $gasto_real = $campaign->ppto_gastos - $suma_gasto_real;
            }

            $suma_gasto_real += $gasto_real;



            /*
             *   Exceso de presupuesto de gasto
             */
            $exceso_ppto_gasto = $month->presupuesto - $gasto_real;


            if ( $key == 0 ) {
                /*
                 *   Importe adicional a provisionar
                 */
                if ( $gasto_real < $month->presupuesto ) {
                    $importe_adicional_a_provisionar    = $month->presupuesto - $gasto_real;
                } else {
                    $importe_adicional_a_provisionar    = 0;
                }

                /**
                 *  Prov acum 2
                 */
                $aux_prov_acum  = $prov_acum_2    = $importe_adicional_a_provisionar;
                //$aux_prov_acum  = $prov_acum_2;

                /**
                 * Gasto ajustado P&L
                 */
                $gasto_ajustado = $gasto_real + $importe_adicional_a_provisionar;

                /**
                 * Aux 1
                 */
                $aux1 = $gasto_real / ( 1 - ( $campaign->margen / 100 ) );

            } else {

                if ( $gasto_real < $month->presupuesto ) {
                    $importe_adicional_a_provisionar    = $month->presupuesto - $gasto_real;

                } elseif( $aux_prov_acum >= 0 ) {

                    if( ( ($month->presupuesto - $gasto_real) + $aux_prov_acum ) > 0 ) {
                        $importe_adicional_a_provisionar = $month->presupuesto - $gasto_real;

                    } else {
                        $importe_adicional_a_provisionar = -$aux_prov_acum;

                    }

                } else {
                    $importe_adicional_a_provisionar    = 0;
                }

                if ( $key == $total_elements ) {
                    $importe_adicional_a_provisionar    = 0;
                }

                /**
                 *  Prov acum 2
                 */
                if( $importe_adicional_a_provisionar + $aux_prov_acum > 0 ) {
                    $aux_prov_acum  = $prov_acum_2 = $importe_adicional_a_provisionar + $aux_prov_acum;

                } else {
                    $aux_prov_acum  = $prov_acum_2 = 0;

                }

                /**
                 * Gasto ajustado P&L
                 */
                $gasto_ajustado = $gasto_real + $importe_adicional_a_provisionar;

                /**
                 * Aux 1
                 */
                $aux1 = $gasto_ajustado / ( 1 - ( $campaign->margen / 100 ) );
            }

            /**
             * Ingreso real
             */
            if ( $prov_acum_2 > 0 ) {
                $ingreso_real = $month->ingreso;

            } elseif( $aux1 < $month->ingreso ) {
                $ingreso_real = $month->ingreso;

            } else {
                $ingreso_real = $aux1;
            }

            if ( $key == $total_elements ) {
                $ingreso_real = $campaign->ingresos - $suma_ingreso_real;
            }

            $suma_ingreso_real += $ingreso_real;

            /**
             * Gasto ajustado P&L
             */
            //$gasto_ajustado = $gasto_real + $importe_adicional_a_provisionar;

            /**
             * % margen recalc
             */
            if ( $prov_acum_2 < 0 ) {
                $margen_recalc = ( $ingreso_real - $gasto_real ) / $ingreso_real;
            } else {
                $margen_recalc = ( $ingreso_real - $gasto_ajustado ) / $ingreso_real;
            }

             /**
              * Resultado real
              */
            $resultado_real = $ingreso_real - $gasto_ajustado;

            /**
             * Check margen real
             */
            $check_margen_real = $resultado_real / $ingreso_real;

            $arreglo = [
                //'ppto_ingreso'                      => $month->ingreso,
                'ingreso_real'                      => $ingreso_real,
                //'ptto_gasto'                        => $month->presupuesto,
                'gasto_real'                        => $gasto_real,
                'exceso_ppto_gato'                  => $exceso_ppto_gasto,
                'importe_adicional_a_provisionar'   => $importe_adicional_a_provisionar,
                'prov_acum2'                        => $prov_acum_2,
                'aux1'                              => $aux1,
                'margen_recalculo'                  => $margen_recalc * 100,
                'gasto_ajustado'                    => $gasto_ajustado,
                'resultado_real'                    => $resultado_real,
                'check_margen_real'                 => $check_margen_real * 100
            ];

            /* se hace la actualizacion dentro de la base de datos */
            $result             = CampaignMonth::whereId( $month->id )->update( $arreglo );
            $arreglo['result']  =  $result;
            $final_response[]   = $arreglo;
        }

        return [
            'status' => 'success',
        ];
    }

}
