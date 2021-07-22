<?php

namespace App\Http\Traits;

use App\Http\Traits\MotorTrait;
use App\Http\Traits\UtilitiesTrait;

use App\Models\CampaignGasto;

/**
* Trait destinado para manejo de archivos en todo el sistema
*/
trait GastosTrait
{
    use UtilitiesTrait;
    use MotorTrait;

    /**
    * @method
    * @param
    * @return
    */
    public function saveUpdate( $campaign, $request, $gasto = null, $type = 'create' )
    {
        /* receive information from request to insert in DB */
        $data           = $request->all();

        if ( $data['dealer_id'] == null ) {
            $data['dealer_id'] = 0;
        }

        if ( $data['influencer_id'] == null ) {
            $data['influencer_id'] = [0];
        }

        /* validacion de tipo numero EU a ISO */
        $data['gasto']  = $this->convertNumberEUToISO( $data['gasto'] );
        unset( $data['_token'] );

        /* guardado de informacion */
        if ( $type == 'create' ) {
            /* se agrega a la data un user_id para poderlo identificar */
            $data['user_id']    = auth()->user()->id;
            $response           = CampaignGasto::create( $data );

            if ( $response != null ) {

                /* se hace el cálculo de la tabla motor */
                $this->calculateMotor( $campaign );

                return [
                    'status'    => 'success',
                    'message'   => 'Gasto guardado exitosamente'
                ];
            }
        }

        if ( $type == 'update' ) {
            $response = CampaignGasto::whereId( $gasto->id )->update( $data );

            if ( $response > 0 ) {

                /* se hace el cálculo de la tabla motor */
                $this->calculateMotor( $campaign );

                return [
                    'status'    => 'success',
                    'message'   => 'Gasto actualizado exitosamente'
                ];
            }
        }

        return [
            'status'    => 'error',
            'message'   => 'Ocurrió un error, por favor intentelo mas tarde'
        ];

    }

}
