<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Influencer extends Model
{
    protected $fillable = [
        'name',
        'lastname',
        'nickname',
        'agencia'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lastname}";
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function availableAlerts()
    {
        return $this->alerts()->where(function(Builder $query){
            $query->whereRaw('"'. now() .'" between start_at and end_at ')->getActives();
        });
    }
}
