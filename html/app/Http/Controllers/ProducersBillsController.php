<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceCampaignExport;
use App\Http\Traits\FileTrait;
use App\Http\Traits\UtilitiesTrait;
use App\Mail\Campaigns\InvoicingCampaign;
use App\Models\Campaign;
use App\Models\CampaignBillMonth;
use App\Models\CampaignGasto;
use App\Models\CampaignMonth;
use App\Models\Dealer;
use App\Models\FacturasGasto;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProducerBills\StoreRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ProducersBillsController extends Controller
{
    use FileTrait;
    use UtilitiesTrait;

    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Producer,Ejecutivo,Administrador']);
    }


    public function index(Campaign $campaign)
    {
        if ( $campaign->status != 1 ) {
            return redirect()->route('producers.dashboard');
        }

        return view("admin.producers.facturas.index",[
            "campaign"  => $campaign
        ]);
    }

    public function create(Campaign $campaign)
    {
        return view("admin.producers.facturas.create",[
            "bill"              => new CampaignBillMonth(),
            "campaign"          => $campaign,
            'dealers'           => Dealer::whereStatus(1)->orderBy('business_name', 'asc')->get(),
            'months'            => CampaignMonth::select('mes', 'id')
                                    ->whereCampaignId( $campaign->id )
                                    ->whereStatus(1)->get(),
            'gastos'            => [],
            'gastos_asociados'  => []
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function getGastos( Campaign $campaign, Request $request )
    {
        $user_id = auth()->user()->id;
        return CampaignGasto::with('dealer')
                    ->with('talent')
                    ->with('influencer')
                    ->whereCampaignMonthId( $request->input('mes') )
                    //->whereStatus(1)
                    ->whereUserId( $user_id )
                    ->get();
        return [ $campaign ,$request->all()];
    }

    /**
    * @method
    * @param
    * @return
    */
    public function saveInfo(Campaign $campaign, StoreRequest $request)
    {
        $newFileName = $this->uploadFileToServer(
            "public/facturas/campaign$campaign->id/",
            $request->file('pdfile')
        );

        /* se almacena el registro de este lado */
        $data                       = $request->all();

        $data['file']               = $newFileName;
        //$data['campaign_id']        = $campaign->id;
        $data['user_id']            = auth()->user()->id;
        $data['campaign_month_id']  = $data['mes'];
        $data['ok_pago']            = isset($data['ok_pago']) ? 1 : 0;

        /* recoleccion de gastos */
        $gastos                     = $data['gastos'];

        /* cambio de precios en caso de traer comas */
        $data['importe_bruto']      = $this->convertNumberEUToISO($data['importe_bruto']);
        $data['importe_neto']       = $this->convertNumberEUToISO($data['importe_neto']);

        unset( $data['_token'] );
        unset( $data['pdfile'] );
        unset( $data['gastos'] );
        unset( $data['mes'] );


        $response = CampaignBillMonth::create( $data );

        $campaign->fileName = $newFileName;
        $users = User::canSentNotifications(Campaign::class,__FUNCTION__)->getAdministrators()->get();
        $collection = new Collection($users->toArray());
        $merged = $collection->merge($campaign->users->toArray());

        Mail::to($merged)->send( new InvoicingCampaign( $campaign ) );


        if ( isset($response->id) ) {

            /*
            *  foreach para insertar los gastos en la tabla relacionar
            *  y poder cambiar el status de los ya usados
            */
            foreach ($gastos as $key => $gasto) {
               CampaignGasto::whereId( $gasto )->update(['status' => 2]);
               FacturasGasto::create([
                   'campaign_bill_month_id' => $response->id,
                   'campaign_gasto_id'      => $gasto
               ]);
            }

            return [
                'status'    => 'success',
                'message'   => 'Factura guardada exitosamente.'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Ocurrió un error, por favor intentelo mas tarde.'
        ];

        return [$campaign, $request->all(), $request->file('pdfile')];
    }


    /**
    * @method
    * @param
    * @return
    */
    public function edit(Campaign $campaign, CampaignBillMonth $factura)
    {
        return view("admin.producers.facturas.edit",[
            'bill'              => $factura,
            "campaign"          => $campaign,
            'dealers'           => Dealer::whereStatus(1)->orderBy('business_name', 'asc')->get(),
            'months'            => CampaignMonth::select('mes', 'id')
                                    ->whereCampaignId( $campaign->id )
                                    ->whereStatus(1)->get(),
            'gastos'            => CampaignGasto::with('dealer')
                                    ->with('talent')
                                    ->with('influencer')
                                    ->whereCampaignMonthId( $factura->campaign_month_id )
                                    ->whereUserId( auth()->user()->id )
                                    ->get(),
            'gastos_asociados'  => $factura->gastos->pluck('pivot')->pluck('campaign_gasto_id')->toArray()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function update(Campaign $campaign, CampaignBillMonth $factura, Request $request)
    {

        if ( $request->file('pdfile') != null ) {
            $newFileName = $this->uploadFileToServer(
                "public/facturas/campaign$campaign->id/",
                $request->file('pdfile')
            );
        } else {
            $newFileName = $factura->file;
        }

        /* se almacena el registro de este lado */
        $data                       = $request->all();
        $data['file']               = $newFileName;
        $data['campaign_month_id']  = $data['mes'];
        $data['ok_pago']            = isset($data['ok_pago']) ? 1 : 0;

        /* recoleccion de gastos */
        $gastos                     = $data['gastos'];

        /* cambio de precios en caso de traer comas */
        $data['importe_bruto']      = $this->convertNumberEUToISO($data['importe_bruto']);
        $data['importe_neto']       = $this->convertNumberEUToISO($data['importe_neto']);

        unset( $data['_token'] );
        unset( $data['pdfile'] );
        unset( $data['gastos'] );
        unset( $data['mes'] );

        $response           = CampaignBillMonth::whereId( $factura->id )->update( $data );

        /* se cambia el status de los gastos que anteriormente estaban asociados */
        $gastos_asociados   = $factura->gastos->pluck('pivot')->pluck('campaign_gasto_id')->toArray();

        foreach ($gastos_asociados as $key => $item) {
            CampaignGasto::whereId( $item )->update(['status' => 1]);
        }

        /* Se quitan los gastos previamente asiciados a tabla pivote */
        FacturasGasto::whereCampaignBillMonthId( $factura->id )->delete();

        if ( $response ) {

            /*
            *  foreach para insertar los gastos en la tabla relacionar
            *  y poder cambiar el status de los ya usados
            */
            foreach ($gastos as $key => $gasto) {
               CampaignGasto::whereId( $gasto )->update(['status' => 2]);
               FacturasGasto::create([
                   'campaign_bill_month_id' => $factura->id,
                   'campaign_gasto_id'      => $gasto
               ]);
            }

            return [
                'status'    => 'success',
                'message'   => 'Factura guardada exitosamente.'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Ocurrió un error, por favor intentelo mas tarde.'
        ];

        return [$campaign, $request->all(), $request->file('pdfile')];
    }

    /**
    * @method
    * @param
    * @return
    */
    public function deleteBill( Campaign $campaign, CampaignBillMonth $factura)
    {
        $response = CampaignBillMonth::whereId( $factura->id )->update(['status' => 0]);

        /*
            se liberan los gastos asociados a esta factura para que se
            pueda agregar una nueva con la relacion nueva
        */
        $gastos_asociados   = $factura->gastos->pluck('pivot')->pluck('campaign_gasto_id')->toArray();
        FacturasGasto::whereCampaignBillMonthId( $factura->id )->delete();

        foreach ($gastos_asociados as $key => $gastoID) {
            CampaignGasto::whereId( $gastoID )->update(['status' => 1]);
        }

        if ( $response ) {
            return redirect()->route('producers.facturas', $campaign)->with('status', [
                'status'    => 'success',
                'message'   => 'Factura eliminada'
            ]);
        }


        return redirect()->route('producers.facturas', $campaign)->with('status', [
            'status'    => 'success',
            'message'   => 'Factura eliminada'
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function exportToCSV(Campaign $campaign)
    {

        $file = [];
        $data = [
            'campaign'  => $campaign
        ];
        $row = array();
        foreach ($data['campaign']->months as $key => $month) {
            foreach ($month->facturas as $key1 => $factura) {
                $url = asset("/storage/facturas/campaign".$data['campaign']->id."/$factura->file");
                $row = [
                    $data['campaign']->name,
                    $month->mes,
                    $factura->no_factura,
                    $this->convertNumberISOToEU($factura->importe_bruto),
                    $this->convertNumberISOToEU($factura->importe_neto),
                    "SI",
                    $factura->condiciones_pago. " días",
                    ( $factura->ok_pago ) ? "SI" : "NO",
                    '=HIPERVINCULO("'.$url.'", "'.$factura->no_factura.'")',
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
                array_push($file, ['']);
            }
            /* dejamos un espacio entre meses */
            array_push($file, ['']);
            array_push($file, ['']);
        }
        $fileName   = $campaign->name."facturas.xlsx";
        $export = new InvoiceCampaignExport($file);
        return Excel::download($export,$fileName);
    }

}
