<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignProducer extends Model
{
    protected $table    = 'campaings_producers';
    protected $fillable = [
        'user_id',
        'campaign_id'
    ];
}
