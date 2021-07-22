<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = [
        'name',
        'dealer_id',
        'ids_tipos',
        'acuerdo'
    ];

    /**
    * @method
    * @param
    * @return
    */
    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}
