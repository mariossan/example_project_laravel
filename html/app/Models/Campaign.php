<?php

namespace App\Models;

use App\Models\CampaignProducer;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'agencia',
        'advertiser_id',
        'month_start',
        'month_end',
        'total_months',
        'extraprima_agencia',
        'ingresos',
        'ppto_gastos',
        'margen'
    ];

    const STATUS_ACTIVA = 1;
    const STATUS_PAUSADA = 2;
    const STATUS_CERRADA = 3;


    /**
    * @method
    * @param
    * @return
    */
    public function users()
    {
        return $this->belongsToMany('App\User', 'campaings_producers', 'campaign_id', 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class,'imageable')->withDefault();
    }

    /**
    * @method
    * @param
    * @return
    */
    public function months()
    {
        return $this->hasMany(CampaignMonth::class);
    }
}
