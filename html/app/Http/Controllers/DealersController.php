<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Http\Requests\DealerRequest;

class DealersController extends Controller
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
        return view('admin.dealers.index',[
            'dealers' => Dealer::whereStatus(1)->orderBy('business_name', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dealers.create',[
            'dealer' => new Dealer()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {
        $data       = $request->validated();
        $data['is_inter_company'] = $request->has('is_inter_company');
        $response   = Dealer::create( $data );

        if ( $response ) {
            return redirect()->route('dealers.index')->with('status', [
                'status'    => 'success',
                'message'   => "Distribuidor $request->name creado"
            ]);
        } else {
            return redirect()->route('dealers.index')->with('status', [
                'status'    => 'error',
                'message'   => "No se pudo crear el distribuidor $request->name"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer)
    {
        return view('admin.dealers.edit',[
            'dealer' => $dealer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, Dealer $dealer)
    {
        $data           = $request->validated();
        $data['is_inter_company'] = $request->has('is_inter_company');
        $responseUpdate = Dealer::whereId( $dealer->id )->update($data);

        if ( $responseUpdate ) {
            return redirect()->route("dealers.index")->with("status", [
                "status"    => "success",
                "message"   => "Distribuidor actualizado"
            ]);

        } else {
            return redirect()->route("dealers.index")->with("status", [
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
    public function deleteItem(Dealer $dealer)
    {
        Dealer::whereId( $dealer->id )->update([
            'status'    => -1
        ]);

        return redirect()->route("dealers.index")->with("status", [
            "status"    => "success",
            "message"   => "$dealer->business_name eliminado correctamente"
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
        $response = Dealer::whereId( $data['dealer_id'] )->update(['warning' => $data['warning']]);

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
}
