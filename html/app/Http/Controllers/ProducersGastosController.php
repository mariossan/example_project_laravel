<?php

namespace App\Http\Controllers;

use App\Http\Traits\GastosTrait;
use App\Models\Campaign;
use App\Models\CampaignGasto;
use App\Models\CampaignMonth;
use App\Models\Dealer;
use App\Models\Influencer;
use App\Models\Talent;
use Illuminate\Http\Request;

class ProducersGastosController extends Controller
{
    use GastosTrait;

    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Producer,Ejecutivo,Administrador']);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function index(Campaign $campaign, $mes = 0)
    {
        if ( $campaign->status != 1 ) {
            return redirect()->route('producers.dashboard');
        }

        return view("admin.producers.gastos.index",[
            "campaign"              => $campaign,
            'dealers'               => Dealer::whereStatus(1)
                                        ->orderBy('business_name', 'asc')
                                        ->select('id', 'business_name','is_inter_company')
                                        ->get(),
            'influencers'           => Influencer::whereStatus(1)
                                        ->orderBy('name', 'asc')
                                        ->select('id', 'name', 'lastname', 'nickname')
                                        ->get(),
            'months'                => CampaignMonth::select('mes', 'id')
                                        ->whereCampaignId( $campaign->id )
                                        ->whereStatus(1)->get(),
            'talents'               => Talent::whereStatus(1)
                                        ->select('id', 'name')
                                        ->get(),
            'gasto'                 => new CampaignGasto(),
            'mes'                   => $mes,
            'dealer_alertas'        => Dealer::whereStatus(1)
                                        ->where('warning', '!=', '')
                                        ->select('id', 'warning')
                                        ->get(),
            'influencer_alertas'    => Influencer::has('alerts')->with('availableAlerts')->get()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function saveinfo(Campaign $campaign, Request $request)
    {
        //$response =  $this->saveUpdate($campaign, $request, null, 'create');
        return redirect()
                ->route('producers.entrada-datos',[$campaign])
                ->with('status', $this->saveUpdate($campaign, $request, null, 'create') );
    }

    /**
    * @method
    * @param
    * @return
    */
    public function editinfo(Campaign $campaign, CampaignGasto $gasto)
    {
        return view("admin.producers.gastos.edit",[
            "campaign"              => $campaign,
            'dealers'               => Dealer::whereStatus(1)
                                        ->orderBy('business_name', 'asc')
                                        ->select('id', 'business_name')
                                        ->get(),
            'influencers'           => Influencer::whereStatus(1)
                                        ->orderBy('name', 'asc')
                                        ->select('id', 'name', 'lastname', 'nickname')
                                        ->get(),
            'months'                => CampaignMonth::select('mes', 'id')
                                        ->whereCampaignId( $campaign->id )
                                        ->whereStatus(1)->get(),
            'talents'               => Talent::whereStatus(1)
                                        ->select('id', 'name')
                                        ->get(),
            'gasto'                 => $gasto,
            'dealer_alertas'        => Dealer::whereStatus(1)
                                        ->where('warning', '!=', '')
                                        ->select('id', 'warning')
                                        ->get(),
            'influencer_alertas'    => Influencer::whereStatus(1)
                                        ->where('warning', '!=', '')
                                        ->select('id', 'warning')
                                        ->get()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function updateInfo(Campaign $campaign, CampaignGasto $gasto, Request $request)
    {

        return redirect()
                ->route('producers.entrada-datos',[$campaign])
                ->with('status', $this->saveUpdate($campaign, $request, $gasto, 'update') );
    }

    /**
     * @method
     * @param CampaignGasto $gasto
     * @return mixed
     */
    public function destroy(CampaignGasto $gasto)
    {
        $gasto->status = 0;
        $gasto->save();
        return redirect()->back()->with("status", [
            "status"    => "success",
            "message"   => "Se elimino correctamente."
        ]);
    }
}
