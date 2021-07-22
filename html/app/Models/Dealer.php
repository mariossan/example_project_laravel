<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'dealer_code',
        'business_name',
        'CifDni',
        'contable_code',
        'warning',
        'is_inter_company'
    ];

    public function getFullNameAttribute()
    {
        $ic = $this->is_inter_company ? 'IC -' : '';
        return "$ic {$this->business_name}";
    }
}
