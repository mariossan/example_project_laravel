<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\ClientcreateRequest;
use Illuminate\Http\Request;

class ClientsController extends Controller
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
        return view("admin.clients.index", [
            "clients" => Client::whereStatus(1)
                            ->select('id', 'client_code', 'business_name', 'fiscal_name')
                            ->orderBy('business_name', 'asc')
                            ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create', [
            'client' => new Client()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientcreateRequest $request)
    {
        $data = $request->validated();

        /* create insert to new cliente */
        $result = Client::create($data);

        if ( $result ) {
            return redirect()->route("clients.index")->with("status", [
                "status"    => "success",
                "message"   => "Cliente creado correctamente"
            ]);

        } else {
            return redirect()->route("clients.index")->with("status", [
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
    public function edit(Client $client)
    {
        return view('admin.clients.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientcreateRequest $request, Client $client)
    {
        $data               = $request->validated();
        $responseUpdate     = Client::whereId( $client->id )->update( $data );

        if ( $responseUpdate ) {
            return redirect()->route("clients.index")->with("status", [
                "status"    => "success",
                "message"   => "Cliente actualizado correctamente"
            ]);

        } else {
            return redirect()->route("clients.index")->with("status", [
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
    public function deleteItem(Client $client)
    {
        Client::whereId( $client->id )->update([
            'status'    => -1
        ]);

        return redirect()->route("clients.index")->with("status", [
            "status"    => "success",
            "message"   => "$client->business_name eliminado correctamente"
        ]);
    }
}
