<?php

namespace App\Http\Controllers;

use App\Exports\SingleCampaignExport;
use App\Http\Requests\Profile\StoreRequest;
use App\Http\Traits\UtilitiesTrait;
use App\Mail\Campaigns\MarkCampaignAsClosed;
use App\Models\Advertiser;
use App\Models\Bitacora;
use App\Models\Campaign;
use App\Models\Client;
use App\Models\Dealer;
use App\Models\Influencer;
use App\Models\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\ImageTrait;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ProducersController extends Controller
{
    use UtilitiesTrait,ImageTrait;
    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Producer,Ejecutivo,Administrador']);
    }

    public function dashboard()
    {
        if( Auth::user()->hasRoles( ["Ejecutivo"]) ) {
            $campaigns = Campaign::whereStatus(1)->orderBy('id', 'desc')->get();
        } else {
            $campaigns = auth()->user()->campaigns()->whereStatus(1)->orderBy('id', 'desc')->get();
        }

        return view('admin.producers.dashboard',[
            'campaigns'     => $campaigns,
            'advertisers'   => Advertiser::whereStatus(1)->orderBy('name', 'asc')->get(),
            'clients'       => Client::whereStatus(1)->orderBy('business_name', 'asc')->get(),
            'influencers'   => Influencer::whereStatus(1)->orderBy('name', 'asc')->get(),
            'dealers'       => Dealer::whereStatus(1)->orderBy('business_name', 'asc')->get()
        ]);
    }

    /**
     * Method to see campaigns dashboard
     */
    public function campaign(Campaign $campaign)
    {
        if ( $campaign->status != 1 ) {
            return redirect()->route('producers.dashboard');
        }

        if( Auth::user()->hasRoles( ["Ejecutivo"]) ) {
            return redirect()->route('producers.entrada-datos', $campaign);
        }

        $campaign->producers_id   = $campaign['users']->pluck('id')->toArray();

        return view('admin.producers.campaing',[
            'campaign'      => $campaign,
            "bitacora"      => Bitacora::with("user")->whereCampaignId( $campaign->id )->orderBy("id", "desc")->get(),
            'producers'     => User::whereStatus(1)->whereRoleId(3)->orderBy('name')->get(),
        ]);
    }

    /**
     * @method Metodo para poder guardar la bitacora de la campaña
     */
    public function bitacoraSave(Request $request)
    {
        $data               = $request->all();
        $data["user_id"]    = auth()->user()->id;
        unset($data["_token"]);
        $response = Bitacora::create( $data );
        // agregamos el nombre a la respuesta
        $response["producer"] = User::whereId(auth()->user()->id)->select("name")->first();
        $response["desde"]      = $response->created_at->diffForHumans();
        return $response;
    }

    /**
     * Method to show table with data from an specific campaign
     * @param Campaign
     * @return view
     */
    public function entradaDatosIndex(Campaign $campaign)
    {
        if ( $campaign->status != 1 ) {
            return redirect()->route('producers.dashboard');
        }
        $campaign->load(['months','months.gastos.user','months.gastos.dealer','months.gastos','months.gastos.month']);

        //return $campaign->months[0]->gastos;
        return view("admin.producers.entrada-datos.index",[
            "campaign"  => $campaign
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function entradaDatosExport(Campaign $campaign)
    {

        $file = [];
        $data = array();
        foreach ($campaign->months as $key => $month) {
            $gastoTotal     = 0;
            $auxGastoTotal  = 0;
            foreach ($month->gastos as $key => $gasto) {
                $auxGastoTotal   = $gastoTotal;
                $gastoTotal     += $gasto->gasto;
                $var            = ($gasto->gasto * 100) / $month->presupuesto;
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
                    number_format( (double) $var, 2, '.', '') . "%"
                ];

                array_push($file, $row);
            }

            if ( count( $month->gastos ) == 0 ) {
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
        $fileName = $campaign->name."_gastos.xlsx";
        $export = new SingleCampaignExport($file);
        return Excel::download($export,$fileName);
    }

    /**
     * @method
     * metodo para cerrar una campaña
     * @param Campaign $campaign
    */
    public function marcarCerrada(Campaign $campaign)
    {

        $campaign->load('users');
        $producer = auth()->user();
        $producer->campaigns()->detach($campaign->id);

        $users = User::canSentNotifications(Campaign::class, __FUNCTION__)->getAdministrators()->get();
        $collection = new Collection($users->toArray());
        $merged = $collection->merge($campaign->users->toArray());

        Mail::to($merged)->send( new MarkCampaignAsClosed($campaign) );

        return redirect()->route('campaigns.index')->with("status", [
            "status"    => "success",
            "message"   => "Se marco como cerrada correctamente."
        ]);
    }

    /**
     * Metodo para actualizar una imagen a una campaña
     * @param Request $request
     * @param Campaign $campaign
     * @return mixed
    */
    public function updateImage(StoreRequest $request,Campaign $campaign)
    {
        Storage::delete($campaign->image->url);

        $image = $this->upload($request->file('image'),"images/campaigns/{$campaign->id}");

        $campaign->image->url = $image;

        if(!$campaign->image){
            $campaign->image->url = $image;
            $campaign->image->imageable_id = $campaign->id;
            $campaign->image->imageable_type = Campaign::class;
        }
        $campaign->push();

        return redirect()->back()->with('status', [
            'status' => 'success',
            'message' => 'La imagen de la campaña se ha actualizado correctamente.'
        ]);
    }

}
