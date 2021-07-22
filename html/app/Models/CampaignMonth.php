<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignMonth extends Model
{
    protected $fillable = [
        'campaign_id',
        'mes',
        'ingreso',
        'presupuesto'
    ];


    /**
    * @method
    * @param
    * @return
    */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class)->where('status','=',1);
    }
    /**
    * @method
    * @param
    * @return
    */
    public function gastos()
    {
        return $this->hasMany(CampaignGasto::class)->where('status','!=',0);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function facturas()
    {
        return $this->hasMany(CampaignBillMonth::class);
    }
}
