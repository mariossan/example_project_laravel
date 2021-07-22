<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CampaignBillMonth extends Model
{
    protected $fillable = [
        "campaign_month_id",
        "user_id",
        "dealer_id",
        "file",
        "no_factura",
        "importe_bruto",
        "importe_neto",
        "ok_pago",
        "condiciones_pago"
    ];

    /**
    * @method
    * @param
    * @return
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function gastos()
    {
        return $this->belongsToMany('App\Models\CampaignGasto', 'facturas_gastos', 'campaign_bill_month_id', 'campaign_gasto_id');
    }
}
