<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influencer;
use App\Http\Requests\InfluencerRequest;

class InfluencersController extends Controller
{
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
        return view("admin.influencers.index",[
            'influencers' => Influencer::whereStatus(1)->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.influencers.create', [
            'influencer' => new Influencer()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InfluencerRequest $request)
    {
        $data   = $request->validated();

        /* create insert to new cliente */
        $result = Influencer::create($data);

        if ( $result ) {
            return redirect()->route("influencers.index")->with("status", [
                "status"    => "success",
                "message"   => "Cliente creado correctamente"
            ]);

        } else {
            return redirect()->route("influencers.index")->with("status", [
                "status"    => "error",
                "message"   => "Ocurrión un problema, por favor intentelo nuevamente"
            ]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Influencer $influencer)
    {
        return view("admin.influencers.edit",[
            'influencer' => $influencer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InfluencerRequest $request, Influencer $influencer)
    {
        $data               = $request->validated();
        $responseUpdate     = Influencer::whereId( $influencer->id )->update( $data );

        if ( $responseUpdate ) {
            return redirect()->route("influencers.index")->with("status", [
                "status"    => "success",
                "message"   => "Cliente actualizado correctamente"
            ]);

        } else {
            return redirect()->route("influencers.index")->with("status", [
                "status"    => "error",
                "message"   => "Ocurrió un error, intente nuevamente."
            ]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteItem(Influencer $influencer)
    {
        Influencer::whereId( $influencer->id )->update([
            'status'    => -1
        ]);

        return redirect()->route("influencers.index")->with("status", [
            "status"    => "success",
            "message"   => "$influencer->name eliminado correctamente"
        ]);
    }

    /**
    * @method Método para poder actualizar una alerta al dealer en cuestión
    * @param request: array que tiene el dealer_id y la alerta a colocar
    * @return array
    */
    public function setAlert( Request $request ) : array
    {
        $data = $request->all();

        if ( $data['warning'] == null ) {
            $data['warning'] = "";
        }

        /* se hace la actualizacion de informacion */
        $response = Influencer::whereId( $data['influencer_id'] )->update(['warning' => $data['warning']]);

        if ( $response ) {
            return [
                'status'    => 'success',
                'message'   => 'La alerta se guardó correctamente.'
            ];
        }

        return [
            'status'    => 'error',
            'message'   => 'Ocurrió un error, intentelo nuevamente.'
        ];
    }

    public function showMyAlerts(Influencer $influencer)
    {
        $influencer->load('alerts');
        return view('admin.influencers.alerts', compact('influencer'));
    }
}
