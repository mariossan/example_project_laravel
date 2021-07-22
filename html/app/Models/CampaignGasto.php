<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CampaignGasto extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_month_id',
        'talent_id',
        'dealer_id',
        'influencer_id',
        'concepto',
        'comentarios',
        'gasto',
        'status'
    ];

    protected $casts = [
        'influencer_id' => 'array'
    ];

    /**
    * @method
    * @param
    * @return
    */
    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class)->withDefault();
    }

    /**
    * @method
    * @param
    * @return
    */
    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function month()
    {
        return $this->belongsTo(CampaignMonth::class);
    }

    /**
     * @method
     * @param
     * @return
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getInfluencers()
    {
        $ids = collect($this->influencer_id)->implode('_');
        return Cache::remember("influencer_{$ids}",60, function(){
            return Influencer::query()->whereIn('id',$this->influencer_id)->get();
        });
    }

}
