<?php

namespace App\Http\Controllers;

use App\Models\{Alert,Influencer};
use App\Mail\Alerts\NewTalentAlert;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Influencer $influencer)
    {
        $alert = new Alert();
        return view('admin.influencers.create-alert', compact('influencer','alert'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $alert = Alert::create($request->all());
        $alert->load('influencer');

        $users = User::canSentNotifications(Alert::class,__FUNCTION__)->getAllActives()->get();
        Mail::to($users)->send( new NewTalentAlert( $alert ) );

        return redirect()->route("influencers.alerts", ['influencer' => $alert->influencer])->with("status", [
            "status"    => "success",
            "message"   => "La alerta de creo correctamente"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function show(Alert $alert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function edit(Alert $alert)
    {
        $influencer = $alert->influencer;
        return view('admin.influencers.edit-alert', compact('alert','influencer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {
        $alert->update($request->all());
        return redirect()->route("influencers.alerts", ['influencer' => $alert->influencer])->with("status", [
            "status"    => "success",
            "message"   => "La alerta de actualizo correctamente"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alert $alert)
    {
        $influencer = $alert->influencer;
        $alert->delete();

        return redirect()->route("influencers.alerts", ['influencer' => $influencer])->with("status", [
            "status"    => "success",
            "message"   => "La alerta de elimino correctamente"
        ]);
    }
}
