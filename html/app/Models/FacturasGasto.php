<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturasGasto extends Model
{
    protected $fillable = [
        'campaign_bill_month_id',
        "campaign_gasto_id"
    ];

}
