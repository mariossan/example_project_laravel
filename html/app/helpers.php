<?php

function setActiveAdmin( $routeName )
{
    return request()->routeIs($routeName) ? 'active': '';
}

function chageDate( $fecha )
{
    $month = [
        '01' => 'Enero',
        '02' => "Febrero",
        '03' => "Marzo",
        '04' => "Abril",
        '05' => "Mayo",
        '06' => "Junio",
        '07' => "Julio",
        '08' => "Agosto",
        '09' => "Septiembre",
        '10' => "Octubre",
        '11' => "Noviembre",
        '12' => "Diciembre"
    ];

    $newDate = explode( "-", $fecha );

    return $month[ $newDate[1] ]." ".$newDate[0];
}


function getJustDate( $fecha )
{
    return  explode(" ",$fecha )[0];
}


/**
 * @method metodo para convertir un numero ISO a EU
 */
function formatNumberEU( $number )
{
    $result = NumberFormatter::create( 'es_ES', NumberFormatter::DECIMAL )->format($number);
    if ( !str_contains($result,",") ) {
        $result .= ",00";
    }

    return  $result;
}


/**
 * @method metodo para convertir un numero ISO a EU
 */
function formatNumberEUIpt( $number )
{
    $result = NumberFormatter::create( 'es_ES', NumberFormatter::DECIMAL )->format($number);
    if ( !str_contains($result,",") ) {
        $result .= ",00";
    }

    return  implode("", explode(".", $result) );
}
