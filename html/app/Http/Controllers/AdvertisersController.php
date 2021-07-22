<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use Illuminate\Http\Request;
use App\Http\Requests\AdvertiserRequest;

class AdvertisersController extends Controller
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
        return view('admin.advertisers.index',[
            'advertisers' => Advertiser::whereStatus(1)->orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advertisers.create',[
            'advertiser' => new Advertiser()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertiserRequest $advertiser)
    {
        $data       = $advertiser->validated();
        $response   = Advertiser::create( $data );

        if ( $response ) {
            return redirect()->route('advertisers.index')->with('status', [
                'status'    => 'success',
                'message'   => "Anunciante $advertiser->name creado"
            ]);
        } else {
            return redirect()->route('advertisers.index')->with('status', [
                'status'    => 'error',
                'message'   => "No se pudo crear el anunciante $advertiser->name"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertiser $advertiser)
    {
        return view('admin.advertisers.edit',[
            'advertiser' => $advertiser
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertiserRequest $request, Advertiser $advertiser)
    {
        $data           = $request->validated();
        $responseUpdate = Advertiser::whereId( $advertiser->id )->update($data);

        if ( $responseUpdate ) {
            return redirect()->route("advertisers.index")->with("status", [
                "status"    => "success",
                "message"   => "Anunciante actualizado"
            ]);

        } else {
            return redirect()->route("advertisers.index")->with("status", [
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
    public function deleteItem(Advertiser $advertiser)
    {
        Advertiser::whereId( $advertiser->id )->update([
            'status'    => -1
        ]);

        return redirect()->route("advertisers.index")->with("status", [
            "status"    => "success",
            "message"   => "$advertiser->name eliminado correctamente"
        ]);
    }
}
