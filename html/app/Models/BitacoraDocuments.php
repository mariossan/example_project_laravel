<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BitacoraDocuments extends Model
{
    protected $fillable = [
        "campaign_id",
        "user_id",
        "description"
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
