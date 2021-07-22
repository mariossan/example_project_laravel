<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CampaignDocument extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_id',
        'file',
        'name',
        'description'
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
}
