<?php

namespace App\Http\Controllers;

use App\Exports\GlobalPositionExport;
use App\Http\Traits\UtilitiesTrait;
use App\Models\CampaignMonth;
use App\Models\Dealer;
use App\Models\Rule;
use App\Models\Talent;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PosicionglobalController extends Controller
{
    use UtilitiesTrait;

    /**
    * @method
    * @param
    * @return
    */
    public function index()
    {
        return view('admin.posicion-global.index', [
            'months' => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Noviembre',
                'Diciembre'
            ],
            'info'  => [],
            'mes'   => -1,
            'anio'  => -1
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function getList( Request $request )
    {
        /* se obtiene la inforamcion para hacer la busqueda */
        $data       = $request->all();
        unset( $data['_token'] );

        $mes        = implode(" ", $data);
        $response   = $this->createInfoToTable( $mes );

        return view('admin.posicion-global.index', [
            'months' => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Noviembre',
                'Diciembre'
            ],
            'info'      => $response['info'],
            'results'   => $response['results'],
            'mes'   => $data['mes'],
            'anio'  => $data['anio']
        ]);
    }


    /**
    * @method
    * @param
    * @return
    */
    public function uniqueValuesArray( $numbers )
    {
        $new_array = array();
        foreach ($numbers as $key => $number) {
            if ( !in_array( $number, $new_array ) ) {
                $new_array[] = $number;
            }
        }

        return $new_array;
    }

    /**
    * @method
    * @param
    * @return
    */
    public function compareArray($arr1, $arr2)
    {
        /* ordenamos los arreglos */
        sort( $arr1 );
        sort( $arr2 );

        $response = array_diff( $arr1, $arr2 );

        if ( count( $response ) == 0 ) {
            return true;
        }

        return false;
    }

    /**
    * @method
    * @param
    * @return
    */
    public function downloadCSV( $month, $year )
    {
        $response   = $this->createInfoToTable( "$month $year" );
        $link       = env('APP_URL');
        $fileName   = "posicion_global.xlsx";

        $response['link']   = $link;
        $response['month']  = "$month $year";


        /* se hace el recorrido de la campa;a para poderla pintar en tabla */
        $file = [];

        $row = array();
        foreach ($response['info'] as $key => $infoItem) {
            $linkMotor  = asset("/campaigns/".$infoItem->campaign->id."/motor");
            $linkDash   = asset("/producers/campaign/resumen/".$infoItem->campaign->id);
            $producers  = implode(",", $infoItem->campaign->users->pluck('name')->toArray() );
            $row = [
                $response['month'],
                '=HYPERLINK("'.$linkMotor.'", "ID '.$infoItem->campaign->id.'")',
                '=HYPERLINK("'.$linkDash.'", "'.$infoItem->campaign->name.'")',
                $infoItem->campaign->client->business_name,
                $infoItem->campaign->advertiser->name,
                $this->convertNumberISOToEU($infoItem->info["ingresoReal"]),
                $this->convertNumberISOToEU($infoItem->info["ingAux1"]),
                $this->convertNumberISOToEU($infoItem->info["talentos"]),
                $this->convertNumberISOToEU($infoItem->info["prodInterna"]),
                $this->convertNumberISOToEU($infoItem->info["prodExterna"]),
                $this->convertNumberISOToEU($infoItem->info["delivery"]),
                $this->convertNumberISOToEU($infoItem->info["provGastoGenerada"]),
                $this->convertNumberISOToEU($infoItem->info["resultado1"]),
                $this->convertNumberISOToEU($infoItem->info["resultado2"]),
                $producers,
                $infoItem->updated_at,
                'activa'
            ];

            array_push($file, $row);

        }

        array_push($file, ['']);

        /* se pintan las sumatorias */
        $sumatorias = [
            '',
            '',
            '',
            '',
            '',
            $this->convertNumberISOToEU($response['results']["sumIngresoReal"]),
            $this->convertNumberISOToEU($response['results']["sumIngAux1"]),
            $this->convertNumberISOToEU($response['results']["sumTalentos"]),
            $this->convertNumberISOToEU($response['results']["sumProdInterna"]),
            $this->convertNumberISOToEU($response['results']["sumProdExterna"]),
            $this->convertNumberISOToEU($response['results']["sumDelivery"]),
            $this->convertNumberISOToEU($response['results']["sumProvGastoGenerada"]),
            $this->convertNumberISOToEU($response['results']["sumResultado1"]),
            $this->convertNumberISOToEU($response['results']["sumResultado2"])
        ];
        array_push($file, $sumatorias);

        $export = new GlobalPositionExport($file);
        return Excel::download($export,$fileName);
    }


    /**
    * @method
    * @param
    * @return
    */
    public function createInfoToTable( $month )
    {
        /* se hace la busqueda dentro de los meses de las campa;as*/
        $info   = CampaignMonth::with('gastos','campaign.advertiser','campaign.client','campaign.users')->whereMes( $month )->get();

        /* traemos todas las reglas */
        $rules  = Rule::whereStatus(1)->get();

        /* ahora recorremos las campa;as con las reglas de casa 1 para encontrar el acuerdo en caso de que exista */
        foreach ($info as $key => $infoItem) {

            $info[$key]->acuerdo = 0;

            foreach ($rules as $key2 => $rule) {

                if ( $infoItem->gastos->where('dealer_id', $rule->dealer_id)->count() > 0 ) {

                    $tipos_rules    = explode(",", $rule->ids_tipos);
                    $tipos_db       = $this->uniqueValuesArray( $infoItem->gastos->where( 'dealer_id', $rule->dealer_id )->pluck('talent_id') );

                    /* busca una coincidencia de las reglas dentro de la db el cual debe ser menor o igual */
                    if ( $this->compareArray( $tipos_rules, $tipos_db ) ) {

                        /* buscamos las coincidencias del dealer_id */
                            $info[$key]->acuerdo = $rule->acuerdo;
                            break;
                    }
                }
            }
        }

        /* carga de la informacion para pintar la tabla */
        $sumIngresoReal         = 0;
        $sumIngAux1             = 0;
        $sumTalentos            = 0;
        $sumProdInterna         = 0;
        $sumProdExterna         = 0;
        $sumDelivery            = 0;
        $sumResultado1          = 0;
        $sumResultado2          = 0;
        $sumProvGastoGenerada   = 0;

        $info = collect($info)->filter(function($item){
            return !is_null($item->campaign);
        });

        foreach ($info as $key => $infoItem) {

            $ingresoReal        = $infoItem->ingreso_real;
            $talentos           = array_sum($infoItem->gastos->where('talent_id', 1)->pluck('gasto')->toArray());
            $prodInterna        = array_sum($infoItem->gastos->where('talent_id', 2)->pluck('gasto')->toArray());
            $prodExterna        = array_sum($infoItem->gastos->where('talent_id', 3)->pluck('gasto')->toArray());
            $delivery           = array_sum($infoItem->gastos->where('talent_id', 4)->pluck('gasto')->toArray());
            $provGastoGenerada  = $infoItem->importe_adicional_a_provisionar;
            $resultado1         = $ingresoReal - $talentos - $prodInterna - $prodExterna - $delivery - $provGastoGenerada;
            $ingAux1            = ($infoItem->acuerdo / 100) * $resultado1;
            $ingAux1            = number_format((float)$ingAux1, 2, '.', '');
            $resultado2         = $resultado1 - $ingAux1;

            $sumIngresoReal         += $ingresoReal;
            $sumIngAux1             += $ingAux1;
            $sumTalentos            += $talentos;
            $sumProdInterna         += $prodInterna;
            $sumProdExterna         += $prodExterna;
            $sumDelivery            += $delivery;
            $sumProvGastoGenerada   += $provGastoGenerada;
            $sumResultado1          += $resultado1;
            $sumResultado2          += $resultado2;

            $info[$key]->info   = [
                'ingresoReal'       => $ingresoReal,
                'talentos'          => $talentos,
                'prodInterna'       => $prodInterna,
                'prodExterna'       => $prodExterna,
                'delivery'          => $delivery,
                'provGastoGenerada' => $provGastoGenerada,
                'resultado1'        => $resultado1,
                'ingAux1'           => $ingAux1,
                'resultado2'        => $resultado2
            ];

        }

        return [
            'info'      => $info,
            'results'   => [
                'sumIngresoReal'        => $sumIngresoReal,
                'sumIngAux1'            => $sumIngAux1,
                'sumTalentos'           => $sumTalentos,
                'sumProdInterna'        => $sumProdInterna,
                'sumProdExterna'        => $sumProdExterna,
                'sumDelivery'           => $sumDelivery,
                'sumProvGastoGenerada'  => $sumProvGastoGenerada,
                'sumResultado1'         => $sumResultado1,
                'sumResultado2'         => $sumResultado2
            ]
        ];

    }
}
