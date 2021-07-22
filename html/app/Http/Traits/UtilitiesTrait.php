<?php

namespace App\Http\Traits;


/**
* Trait destinado para manejo de archivos en todo el sistema
*/
trait UtilitiesTrait
{
    /**
     * @method metodo para convertir un numero EUROPEO a ISO
    * @return
    */
    public function convertNumberEUToISO( $number )
    {
        return implode(".", explode(",", $number));
    }

    /**
     * @method Metodo para convertir un numero de ISO a EUROPEO
     */
    public function convertNumberISOToEU( $number)
    {
        return implode(",", explode(".", $number));
    }

}
