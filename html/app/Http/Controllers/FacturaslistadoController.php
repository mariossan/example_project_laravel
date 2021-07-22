<?php

namespace App\Http\Controllers;

use App\Exports\CampaignsExport;
use App\Exports\SingleCampaignExport;
use App\Http\Traits\UtilitiesTrait;
use App\Models\Campaign;
use App\Models\CampaignMonth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FacturaslistadoController extends Controller
{
    use UtilitiesTrait;

    /**
    * @method
    * @param
    * @return
    */
    public function downloadFacturas()
    {
        $file = [];
        $campaigns = Campaign::with('months.facturas')->whereStatus(1)->orderBy('id', 'desc')->get();

        foreach ($campaigns as $key => $campaign) {
            $row = array();
            foreach ($campaign->months as $key => $month) {
                foreach ($month->facturas as $key1 => $factura) {
                    $url = asset("/storage/facturas/campaign".$campaign->id."/$factura->file");
                    $row = [
                        $campaign->name,
                        $month->mes,
                        $factura->no_factura,
                        $this->convertNumberISOToEU($factura->importe_bruto),
                        $this->convertNumberISOToEU($factura->importe_neto),
                        "SI",
                        $factura->condiciones_pago. " días",
                        ( $factura->ok_pago ) ? "SI" : "NO",
                        $url,
                        $factura->no_factura
                    ];

                    foreach ($factura->gastos as $key2 => $gasto) {
                        $influencers = $gasto->getInfluencers()->implode('full_name', "\n");
                        $dataToPrint = $row;

                        $dataToPrint[] = '';
                        $dataToPrint[] = CampaignMonth::whereId($gasto->campaign_month_id)->first()->mes;
                        $dataToPrint[] = $gasto->talent->name;
                        $dataToPrint[] = $gasto->dealer->business_name;
                        $dataToPrint[] = $influencers;
                        $dataToPrint[] = $gasto->concepto;
                        $dataToPrint[] = $this->convertNumberISOToEU($gasto->gasto);
                        array_push($file, $dataToPrint);
                    }
                }
            }
            array_push($file, ['']);
        }

        $export = new CampaignsExport($file);
        $fileName = "facturas_all_" . now()->timestamp .".xlsx";
        return Excel::download($export,$fileName);
    }

    public function downloadGastos()
    {
        $campaigns = Campaign::with('months','months.facturas','months.gastos')->whereStatus(1)->orderBy('id', 'desc')->get();
        $file = [];
        foreach ($campaigns as $campaign) {
            foreach ($campaign->months as $key => $month) {
                $gastoTotal = 0;
                $auxGastoTotal = 0;
                foreach ($month->gastos as $key => $gasto) {
                    $auxGastoTotal = $gastoTotal;
                    $gastoTotal += $gasto->gasto;
                    $var = ($gasto->gasto * 100) / $month->presupuesto;
                    $influencers = $gasto->getInfluencers()->implode('full_name', "\n");

                    $row = [
                        $campaign->name,
                        $month->mes,
                        $gasto->talent->name,
                        isset($gasto->dealer->business_name) ? $gasto->dealer->business_name : "",
                        $influencers,
                        $gasto->concepto,
                        $gasto->comentarios,
                        $this->convertNumberISOToEU($month->presupuesto - $auxGastoTotal),
                        $this->convertNumberISOToEU($gasto->gasto),
                        $this->convertNumberISOToEU($month->presupuesto - $gastoTotal),
                        number_format((double)$var, 2, '.', '') . "%"
                    ];

                    array_push($file, $row);
                }

                if (count($month->gastos) == 0) {
                    $row = [
                        $campaign->name,
                        $month->mes,
                        '-',
                        '-',
                        '-',
                        '-',
                        '-',
                        $this->convertNumberISOToEU($month->presupuesto),
                        $this->convertNumberISOToEU(0),
                        $this->convertNumberISOToEU($month->presupuesto - $gastoTotal),
                        '0%'
                    ];
                    array_push($file, $row);
                }

                /* cuando se termina el foreach se escriben los resultados */
                $row = [
                    $campaign->name,
                    $month->mes,
                    '',
                    '',
                    '',
                    '',
                    '',
                    $this->convertNumberISOToEU($month->presupuesto),
                    $this->convertNumberISOToEU($gastoTotal),
                    $this->convertNumberISOToEU($month->presupuesto - $gastoTotal),
                    '',
                ];
                /* dejamos un espacio entre meses */
                $row = [''];
                array_push($file, $row);
            }
            $row = [
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
                "------------------------------------",
            ];
            array_push($file, $row);
        }
        $fileName = "all_gastos.xlsx";
        $export = new SingleCampaignExport($file);
        return Excel::download($export,$fileName);
    }
}
