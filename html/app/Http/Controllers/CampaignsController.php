<?php

namespace App\Http\Controllers;

use App\Exports\MotorSingleCampaignExport;
use App\Http\Requests\CampaignRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Http\Traits\MotorTrait;
use App\Models\Advertiser;
use App\Models\Campaign;
use App\Models\CampaignMonth;
use App\Models\CampaignProducer;
use App\Models\Client;
use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\UtilitiesTrait;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\Campaigns\{NewCampaign,CampaignDeleted};
use Illuminate\Support\Facades\Mail;

class CampaignsController extends Controller
{
    use UtilitiesTrait;
    use MotorTrait;


    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Administrador']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.campaigns.index",[
            'campaigns' => Campaign::where("status", "<>", 0)->orderBy('id', 'desc')->get()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function getMonts(Campaign $campaign)
    {
        return $campaign->months;
    }

    /**
    * @method
    * @param
    * @return
    */
    public function deleteCampaign(Campaign $campaign)
    {
        Campaign::whereId($campaign->id)->update(['status' => 0]);

        $users = User::canSentNotifications(Campaign::class,'destroy')->getAdministrators()->get();
        Mail::to($users)->send( new CampaignDeleted( $campaign ) );

        return redirect()->route('campaigns.index')->with('status', [
            'status' => 'success',
            'message' => 'Campaña eliminada exitosamente'
        ]);
    }


    /**
    * @method
    * @param
    * @return
    */
    public function montChangeStatus(CampaignMonth $campaignMonth, $status = 0)
    {
        /* se hace el cambio de status */
        $response   = CampaignMonth::whereId($campaignMonth->id)->update(['status' => $status]);
        $respuesta  = ( $status == 0 ) ? 'BLOQUEADO' : 'ACTIVADO';

        if ( $response ) {
            return [
                'status' => 'success',
                'message' => "El mes se ha $respuesta satisfactoriamente"
            ];
        }

        return [
            'status'    => 'error',
            'message'   => "El mes se ha $respuesta satisfactoriamente"
        ];

        return [ $campaignMonth, $status ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.campaigns.create",[
            'campaign'      => new Campaign(),
            "clients"       => Client::whereStatus(1)->orderBy('business_name', 'asc')->get(),
            "advertisers"   => Advertiser::whereStatus(1)->orderBy('name', 'asc')->get(),
            'producers'     => User::whereStatus(1)->whereRoleId(3)->orderBy('name')->get(),
            'years'         => [],
            'months'        => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {
        $data       = $request->validated();
        $campaign   = $data;

        unset( $campaign['mes']);
        unset( $campaign['ingresosMes']);
        unset( $campaign['presupuestosMes']);
        unset( $campaign['user_id']);

        $campaign['ingresos']       = $this->convertNumberEUToISO( $campaign['ingresos'] );
        $campaign['ppto_gastos']    = $this->convertNumberEUToISO( $campaign['ppto_gastos'] );

        $campaign['extraprima_agencia'] = 0;

        /* se hace guardado de la informacion de  la campaña*/
        $IdCampaign = Campaign::create($campaign);

        /* insercion de los producers con las campañas */
        foreach ($data["user_id"] as $key => $producer) {
            CampaignProducer::create([
                'user_id'       => $producer,
                'campaign_id'   => $IdCampaign->id
            ]);
        }

        /**
         * Inserción de meses relaciondos
         */
        for ($i=0; $i < count( $data['mes'] ); $i++) {
            CampaignMonth::create([
                'campaign_id'   => $IdCampaign->id,
                'mes'           => $data['mes'][$i],
                'ingreso'       => $this->convertNumberEUToISO( $data['ingresosMes'][$i] ),
                'presupuesto'   => $this->convertNumberEUToISO( $data['presupuestosMes'][$i] )
            ]);
        }
        $campaign = new Campaign();
        $campaign->fill($data);

        return redirect()->route('campaigns.index')->with('status', [
            'status' => 'success',
            'message' => 'Campaña creada exitosamente'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {
        $campaign['producers_id']   = $campaign['users']->pluck('id')->toArray();
        $campaign['months']         = CampaignMonth::whereCampaign_id( $campaign->id )->get();

        // hacemos el cambio de numeros ISO a EU
        foreach( $campaign["months"] as $key => $month ) {
            $campaign["months"][$key]->ingreso = $this->convertNumberISOToEU( $campaign["months"][$key]->ingreso );
            $campaign["months"][$key]->presupuesto = $this->convertNumberISOToEU( $campaign["months"][$key]->presupuesto );
        }

        /* se obtiene el ultimo a;o seleccioando */
        $anio = (int) explode('-', $campaign->month_end)[0];

        return view("admin.campaigns.edit",[
            'campaign'      => $campaign,
            'producers'     => User::whereStatus(1)->whereRoleId(3)->select("id", "name")->get(),
            "clients"       => Client::whereStatus(1)->orderBy('business_name', 'asc')->get(),
            "advertisers"   => Advertiser::whereStatus(1)->orderBy('name', 'asc')->get(),
            'producers'     => User::whereStatus(1)->whereRoleId(3)->orderBy('name')->get(),
            'years'         => [$anio, $anio + 1],
            'months'        => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignUpdateRequest $request, Campaign $campaign)
    {
        $data           = $request->validated();
        $campaignData   = $data;

        unset( $campaignData['mes']);
        unset( $campaignData['ingresosMes']);
        unset( $campaignData['presupuestosMes']);
        unset( $campaignData['user_id']);

        $campaignData['ingresos']       = $this->convertNumberEUToISO( $campaignData['ingresos'] );
        $campaignData['ppto_gastos']    = $this->convertNumberEUToISO( $campaignData['ppto_gastos'] );


        /* Se actuaiza la campaña */
        $response = Campaign::whereId($campaign->id)->update($campaignData);

        /* se eliminan los producers anteriores */
        CampaignProducer::whereCampaignId($campaign->id)->delete();

        /* insercion de los producers con las campañas */
        foreach ($data["user_id"] as $key => $producer) {
            CampaignProducer::create([
                'user_id'       => $producer,
                'campaign_id'   => $campaign->id
            ]);
        }

        /**
         * Inserción de meses relaciondos
         * se hace la busqueda de cada mes para hacer los cambios de ingresos y presupuestos
         */
        for ($i=0; $i < count( $data['mes'] ); $i++) {
            /* se busca el mes con la campania */
            $month =  CampaignMonth::whereCampaignId( $campaign->id )->whereMes( $data['mes'][$i] )->first();

            if ( $month != null ) { // se ha encontrado el mes y se actualiza
                CampaignMonth::whereId( $month->id )->update([
                    'ingreso'       => $this->convertNumberEUToISO( $data['ingresosMes'][$i] ),
                    'presupuesto'   => $this->convertNumberEUToISO( $data['presupuestosMes'][$i] )
                ]);

            } else { // el mes para esa campa;a aun no existe y se necesita crear

                CampaignMonth::create([
                    'campaign_id'   => $campaign->id,
                    'mes'           => $data['mes'][$i],
                    'ingreso'       => $this->convertNumberEUToISO( $data['ingresosMes'][$i] ),
                    'presupuesto'   => $this->convertNumberEUToISO( $data['presupuestosMes'][$i] )
                ]);

            }
        }

        /* si todo va bien hasta este punto, ahora se hace una actualizacion sobre la tabla motor */
        $this->calculateMotor($campaign);

        return redirect()->route('campaigns.index')->with('status', ['status' => 'success', 'message' => 'Campaña actualizada exitosamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
    * @method
    * @param
    * @return
    */
    public function motor( Campaign $campaign )
    {
        return view('admin.campaigns.motor', [
            'campaign' => $campaign
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function setCalendario(Campaign $campaign, CampaignMonth $month, Request $request)
    {
        $data               = $request->all();
        $data['importe']    = $this->convertNumberEUToISO($data['importe']);

        unset( $data['_token'] );

        /* se actualiza la informacion */
        $response =  CampaignMonth::whereId( $month->id )->update($data);

        if ( $response ) {
            return redirect()->route('producers.resumen', $campaign)->with('status', [
                'status'    => 'success',
                'message'   => 'Información guardada exitosamente.'
            ]);
        }
        return [ $campaign, $month, $request->all(), $response];
    }

    /**
    * @method
    * @param
    * @return
    */
    public function campaigtnChangeStatus(Campaign $campaign, Request $request)
    {
        $data       = $request->all();
        Campaign::whereId( $campaign->id )->update(["status" => $data["newState"]]);

        return redirect()->route("campaigns.index")->with("status", ["status" => "success", "message" => "Camnapaña actualizada con exito"]);
    }


    /**
    * @method Exporta la tabla MOTOR
    * @param
    * @return
    */
    public function expotToCSV(Campaign $campaign)
    {

        $columns =  [];
        /* se hace el recorrido de la campa;a para poderla pintar en tabla */
        $file = [];

        /* se ponte el pintado de esa informacion */
        $data = [
            $campaign->name,
            $campaign->ingresos,
            $campaign->ppto_gastos,
            $campaign->margen."%"
        ];
        array_push($file, $data);

        /* se agregan 2 saltos de linea */
        array_push($file, ['']);
        array_push($file, ['']);

        /*
            Seccion donde se pinta la inforamcion de la tabla motor ahora si
         */
        $columns = [
            'Mes',
            'Ppto Ingreso',
            'Ingreso real',
            'Ppto gasto',
            'Gasto real',
            'Margen Ppto.',
            'Exceso Ppto Gasto',
            'Prov. Gasto Generada',
            'Prov Acum 2',
            'Axu1',
            '% margen recal',
            'Gasto Ajustado P&L',
            'Resultado real',
            'Check Margen',
        ];
        array_push($file, $columns);


        $sum_ingreso_real   = 0;
        $sum_ppto_gasto     = 0;
        $sum_gasto_real     = 0;
        $sum_gasto_ajustado = 0;
        $sum_resultado_real = 0;
        $final_prov_acum    = 0;


        $row = array();
        foreach ($campaign->months as $key => $month) {

            $sum_ingreso_real   += $month->ingreso_real;
            $sum_ppto_gasto     += $month->presupuesto;
            $sum_gasto_real     += $month->gasto_real;
            $sum_gasto_ajustado += $month->gasto_ajustado;
            $sum_resultado_real += $month->resultado_real;
            $final_prov_acum    = $month->prov_acum2;

            $data = [
                $month->mes,
                $this->convertNumberISOToEU($month->ingreso),
                $this->convertNumberISOToEU($month->ingreso_real),
                $this->convertNumberISOToEU($month->presupuesto),
                $this->convertNumberISOToEU($month->gasto_real),
                $campaign->margen."%",
                $this->convertNumberISOToEU($month->exceso_ppto_gato),
                $this->convertNumberISOToEU($month->importe_adicional_a_provisionar),
                $this->convertNumberISOToEU($month->prov_acum2),
                $this->convertNumberISOToEU($month->aux1),
                $month->margen_recalculo."%",
                $this->convertNumberISOToEU($month->gasto_ajustado),
                $this->convertNumberISOToEU($month->resultado_real),
                $month->check_margen_real."%"
            ];

            array_push($file, $data);
        }

        /* dejamos un espacio entre meses */
        array_push($file, ['']);


        /* se ponen los resultados */
        $data = [
            '',
            '',
            $this->convertNumberISOToEU($sum_ingreso_real),
            $this->convertNumberISOToEU($sum_ppto_gasto),
            $this->convertNumberISOToEU($sum_gasto_real),
            $campaign->margen."%",
            '',
            '',
            '',
            '',
            '',
            $this->convertNumberISOToEU($sum_gasto_ajustado),
            $this->convertNumberISOToEU($sum_resultado_real),
            ''
        ];
        array_push($file, $data);

        $data = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Ajuste prov restante',
            $this->convertNumberISOToEU($final_prov_acum)
        ];
        array_push($file, $data);


        $check_gasto_ajustado   = $sum_gasto_ajustado - $final_prov_acum;
        $check_resultado_real   = $sum_ingreso_real - $check_gasto_ajustado;
        try {
            $check_porcentaje    = ($check_resultado_real * 100) / $sum_ingreso_real;
        } catch (\Throwable $th) {
            $check_porcentaje    = 0;
        }

        $data = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'Check Gasto',
            $this->convertNumberISOToEU($check_gasto_ajustado),
            $this->convertNumberISOToEU($check_resultado_real),
            $check_porcentaje."%"
        ];
        array_push($file, $data);

        $fileName   = $campaign->name."_motor.xlsx";
        $export = new MotorSingleCampaignExport($file);
        return Excel::download($export,$fileName);
    }

}
