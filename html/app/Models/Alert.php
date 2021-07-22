<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['title','description','start_at','end_at','influencer_id'];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static $opsStatus = [
        self::STATUS_ACTIVE => 'Activo',
        self::STATUS_INACTIVE => 'Finalizado'
    ];


    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    /**
     * metodo para verificar si la alerta esta por vencer en 3,2,1 días
     * @return bool
    */
    public function isDueToExpire(): bool
    {
        $diffInDays = $this->end_at->diffInDays(now()) + 1;
        if($diffInDays == 0){
            $this->markAsFinished();
        }
        return $diffInDays > 0 && $diffInDays <= 3;
    }


    /**
     * Funcion publica que devuelve el estatus de una alerta
     * @return string
    */
    public function getStatus() : string
    {
        return self::$opsStatus[$this->status];
    }

    /**
     * Funcion publica para marcar una alerta como fincalizado
     * @return void
    */
    public function markAsFinished()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->save();
    }

    /**
     * Funcion scope para obtener alertas activas
     * @param Builder $query
     * @return Builder
     */
    public function scopeGetActives(Builder $query): Builder
    {
        return $query->where('status','=',self::STATUS_ACTIVE);
    }
}
